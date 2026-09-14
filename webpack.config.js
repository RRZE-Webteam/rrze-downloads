const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { getWebpackEntryPoints } = require( '@wordpress/scripts/utils/config' );

module.exports = {
	...defaultConfig,
	output: {
		...defaultConfig.output,
		clean: {
			keep: /^(fonts|images|js|css)\//,
		},
	},
	entry: getWebpackEntryPoints( 'script' )(),
};
