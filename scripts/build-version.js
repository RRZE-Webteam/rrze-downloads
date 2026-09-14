/* eslint-disable no-console */
'use strict';

var fs = require( 'fs' );
var path = require( 'path' );

function readJson( filePath ) {
	var raw = fs.readFileSync( filePath, 'utf8' );
	return JSON.parse( raw );
}

function writeJson( filePath, obj ) {
	var out = JSON.stringify( obj, null, 2 ) + '\n';
	fs.writeFileSync( filePath, out, 'utf8' );
}

function parseSemver( version ) {
	var m = version.match( /^(\d+)\.(\d+)\.(\d+)(?:-([0-9A-Za-z.-]+))?$/ );
	if ( ! m ) {
		throw new Error( 'Invalid semver: ' + version );
	}

	return {
		major: parseInt( m[ 1 ], 10 ),
		minor: parseInt( m[ 2 ], 10 ),
		patch: parseInt( m[ 3 ], 10 ),
		prerelease: m[ 4 ] || '',
	};
}

function formatSemver( v ) {
	var base =
		String( v.major ) + '.' + String( v.minor ) + '.' + String( v.patch );
	if ( v.prerelease ) {
		return base + '-' + v.prerelease;
	}
	return base;
}

function bumpDev( version ) {
	var v = parseSemver( version );

	if ( ! v.prerelease ) {
		v.prerelease = '1';
		return formatSemver( v );
	}

	var m = v.prerelease.match( /^(\d+)$/ );
	if ( ! m ) {
		v.prerelease = '1';
		return formatSemver( v );
	}

	var n = parseInt( m[ 1 ], 10 );
	v.prerelease = String( n + 1 );

	return formatSemver( v );
}

function bumpProd( version ) {
	var v = parseSemver( version );

	v.prerelease = '';
	v.patch = v.patch + 1;

	return formatSemver( v );
}

function bumpRelease( version ) {
	var v = parseSemver( version );

	v.prerelease = '';
	v.minor = v.minor + 1;
	v.patch = 0;

	return formatSemver( v );
}

function replaceInFile( filePath, replacer ) {
	var content = fs.readFileSync( filePath, 'utf8' );
	var updated = replacer( content );

	if ( updated !== content ) {
		fs.writeFileSync( filePath, updated, 'utf8' );
	}
}

function setReadmeTxtVersion( pluginRoot, newVersion ) {
	var filePath = path.join( pluginRoot, 'readme.txt' );
	var replacements = 0;

	if ( ! fs.existsSync( filePath ) ) {
		return;
	}

	replaceInFile( filePath, function replaceReadmeVersion( content ) {
		content = content.replace(
			/^(Stable tag:\s*)(.+)$/m,
			function replaceStableTag( match, p1 ) {
				replacements++;
				return p1 + newVersion;
			}
		);

		content = content.replace(
			/^(Version:\s*)(.+)$/m,
			function replaceVersion( match, p1 ) {
				replacements++;
				return p1 + newVersion;
			}
		);

		return content;
	} );

	if ( replacements === 0 ) {
		throw new Error( 'No version field found in readme.txt' );
	}
}

function setPluginVersion( pluginRoot, pkg, newVersion ) {
	if ( ! pkg.main || typeof pkg.main !== 'string' ) {
		throw new Error( 'package.json has no valid "main" entry' );
	}

	var filePath = path.join( pluginRoot, pkg.main );
	var replacements = 0;

	if ( ! fs.existsSync( filePath ) ) {
		throw new Error( 'Plugin main file not found: ' + filePath );
	}

	replaceInFile( filePath, function replacePluginVersion( content ) {
		content = content.replace(
			/^(\s*(?:\*\s*)?Version:\s*)(.+)$/m,
			function replaceHeaderVersion( match, p1 ) {
				replacements++;
				return p1 + newVersion;
			}
		);

		return content;
	} );

	if ( replacements === 0 ) {
		throw new Error(
			'No plugin header version field found in ' + pkg.main
		);
	}
}

function setConfigVersion( pluginRoot, newVersion ) {
	var filePath = path.join( pluginRoot, 'includes', 'Config.php' );
	var replacements = 0;

	if ( ! fs.existsSync( filePath ) ) {
		throw new Error( 'Config file not found: ' + filePath );
	}

	replaceInFile( filePath, function replaceConfigVersion( content ) {
		return content.replace(
			/(\s*'version'\s*=>\s*')[^']*(')/,
			function replaceVersion( match, p1, p2 ) {
				replacements++;
				return p1 + newVersion + p2;
			}
		);
	} );

	if ( replacements === 0 ) {
		throw new Error( 'No version field found in ' + filePath );
	}
}

function setBlockVersion( pluginRoot, newVersion ) {
	var filePath = path.join( pluginRoot, 'src', 'block', 'block.json' );
	var block;

	if ( ! fs.existsSync( filePath ) ) {
		return;
	}

	block = readJson( filePath );
	block.version = newVersion;
	writeJson( filePath, block );
}

function setPluginCompatibility( pluginRoot, pkg ) {
	if ( ! pkg.main || typeof pkg.main !== 'string' ) {
		throw new Error( 'package.json has no valid "main" entry' );
	}

	var compatibility = pkg.compatibility;
	var filePath = path.join( pluginRoot, pkg.main );

	if ( ! compatibility || typeof compatibility !== 'object' ) {
		return;
	}

	if ( ! fs.existsSync( filePath ) ) {
		throw new Error( 'Plugin main file not found: ' + filePath );
	}

	replaceInFile( filePath, function replacePluginCompatibility( content ) {
		var updated = content;

		if (
			typeof compatibility.phprequires === 'string' &&
			compatibility.phprequires.trim() !== ''
		) {
			updated = updated.replace(
				/^(\s*(?:\*\s*)?Requires PHP:\s*)(.+)$/m,
				function replacePhpRequirement( match, p1 ) {
					return p1 + compatibility.phprequires.trim();
				}
			);

			updated = updated.replace(
				/const\s+RRZE_PHP_VERSION\s*=\s*['"][^'"]*['"]\s*;/,
				function replacePhpConstant() {
					return (
						"const RRZE_PHP_VERSION = '" +
						compatibility.phprequires.trim() +
						"';"
					);
				}
			);
		}

		if (
			typeof compatibility.wprequires === 'string' &&
			compatibility.wprequires.trim() !== ''
		) {
			updated = updated.replace(
				/^(\s*(?:\*\s*)?Requires at least:\s*)(.+)$/m,
				function replaceWpRequirement( match, p1 ) {
					return p1 + compatibility.wprequires.trim();
				}
			);

			updated = updated.replace(
				/const\s+RRZE_WP_VERSION\s*=\s*['"][^'"]*['"]\s*;/,
				function replaceWpConstant() {
					return (
						"const RRZE_WP_VERSION = '" +
						compatibility.wprequires.trim() +
						"';"
					);
				}
			);
		}

		return updated;
	} );

	setConfigCompatibility( pluginRoot, compatibility );
}

function setConfigCompatibility( pluginRoot, compatibility ) {
	var filePath = path.join( pluginRoot, 'includes', 'Config.php' );

	if ( ! fs.existsSync( filePath ) ) {
		throw new Error( 'Config file not found: ' + filePath );
	}

	replaceInFile( filePath, function replaceConfigCompatibility( content ) {
		var updated = content;

		if (
			typeof compatibility.phprequires === 'string' &&
			compatibility.phprequires.trim() !== ''
		) {
			updated = updated.replace(
				/(\s*'required_php_version'\s*=>\s*')[^']*(')/,
				function replacePhpVersion( match, p1, p2 ) {
					return p1 + compatibility.phprequires.trim() + p2;
				}
			);
		}

		if (
			typeof compatibility.wprequires === 'string' &&
			compatibility.wprequires.trim() !== ''
		) {
			updated = updated.replace(
				/(\s*'required_wp_version'\s*=>\s*')[^']*(')/,
				function replaceWpVersion( match, p1, p2 ) {
					return p1 + compatibility.wprequires.trim() + p2;
				}
			);
		}

		return updated;
	} );
}

function setPackageLockVersion( pluginRoot, newVersion ) {
	var filePath = path.join( pluginRoot, 'package-lock.json' );
	var lock;

	if ( ! fs.existsSync( filePath ) ) {
		return;
	}

	lock = readJson( filePath );
	lock.version = newVersion;

	if (
		lock.packages &&
		typeof lock.packages === 'object' &&
		lock.packages[ '' ] &&
		typeof lock.packages[ '' ] === 'object'
	) {
		lock.packages[ '' ].version = newVersion;
	}

	writeJson( filePath, lock );
}

function getString( obj, key, fallback ) {
	if (
		! obj ||
		typeof obj !== 'object' ||
		typeof obj[ key ] !== 'string' ||
		obj[ key ].trim() === ''
	) {
		return fallback;
	}

	return obj[ key ].trim();
}

function getTranslationContact( pkg ) {
	var author = getString( pkg, 'author', '' );
	var authorName;
	var email;

	if ( pkg.author && typeof pkg.author === 'object' ) {
		authorName = getString( pkg.author, 'name', '' );
	} else {
		authorName = author;
	}

	email = getString( pkg.supports, 'email', '' );
	authorName = authorName.replace( /\s*\([^)]*\)\s*$/, '' ).trim();

	if ( ! authorName ) {
		authorName = getString(
			pkg,
			'title',
			getString( pkg, 'name', 'RRZE Webteam' )
		);
	}

	if ( email ) {
		return authorName + ' <' + email + '>';
	}

	return authorName;
}

function replacePotHeaderField( content, field, value ) {
	var pattern = new RegExp( '("' + field + ': )[^"]*(\\\\n")' );

	if ( ! pattern.test( content ) ) {
		throw new Error( 'POT header field not found: ' + field );
	}

	return content.replace(
		pattern,
		function replaceHeaderField( match, prefix, suffix ) {
			return prefix + value + suffix;
		}
	);
}

function setPotMetadata( pluginRoot, pkg ) {
	var textDomain = getString( pkg, 'textdomain', '' );
	var filePath;
	var repository;
	var issueUrl;
	var contact;

	if ( ! textDomain ) {
		return;
	}

	filePath = path.join( pluginRoot, 'languages', textDomain + '.pot' );
	if ( ! fs.existsSync( filePath ) ) {
		return;
	}

	repository =
		pkg.repository && typeof pkg.repository === 'object'
			? pkg.repository
			: {};
	issueUrl = getString(
		repository,
		'issues',
		getString( repository, 'url', '' )
	);
	contact = getTranslationContact( pkg );

	replaceInFile( filePath, function replacePotMetadata( content ) {
		content = replacePotHeaderField(
			content,
			'Project-Id-Version',
			getString( pkg, 'title', getString( pkg, 'name', 'RRZE Plugin' ) ) +
				' ' +
				pkg.version
		);
		content = replacePotHeaderField(
			content,
			'Report-Msgid-Bugs-To',
			issueUrl
		);
		content = replacePotHeaderField( content, 'Last-Translator', contact );
		content = replacePotHeaderField( content, 'Language-Team', contact );

		return content;
	} );
}

function getNextVersion( mode, currentVersion ) {
	if ( mode === 'dev' ) {
		return bumpDev( currentVersion );
	}

	if ( mode === 'prod' ) {
		return bumpProd( currentVersion );
	}

	if ( mode === 'release' ) {
		return bumpRelease( currentVersion );
	}

	throw new Error( 'Unsupported mode: ' + mode );
}

function main() {
	var mode = process.argv[ 2 ];
	if ( mode !== 'dev' && mode !== 'prod' && mode !== 'release' ) {
		console.error(
			'Usage: node scripts/build-version.js dev|prod|release'
		);
		process.exit( 1 );
	}

	var pluginRoot = process.cwd();
	var packagePath = path.join( pluginRoot, 'package.json' );
	var pkg = readJson( packagePath );

	if ( ! pkg.version || typeof pkg.version !== 'string' ) {
		throw new Error( 'package.json has no valid version' );
	}

	var current = pkg.version;
	var next = getNextVersion( mode, current );

	pkg.version = next;
	writeJson( packagePath, pkg );
	setPackageLockVersion( pluginRoot, next );

	setReadmeTxtVersion( pluginRoot, next );
	setPluginVersion( pluginRoot, pkg, next );
	setConfigVersion( pluginRoot, next );
	setBlockVersion( pluginRoot, next );
	setPluginCompatibility( pluginRoot, pkg );
	setPotMetadata( pluginRoot, pkg );

	console.log( 'Version bumped (' + mode + '): ' + current + ' -> ' + next );
}

main();
