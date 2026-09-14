jQuery( document ).ready( function ( $ ) {
	var disabled_color = '#b4b9be';

	function strcmp( a, b ) {
		if ( a.toString() < b.toString() ) return -1;
		if ( a.toString() > b.toString() ) return 1;
		return 0;
	}

	function setCookie( mode ) {
		document.cookie = 'mode=' + mode + ';';
	}

	function getCookie() {
		var ret = 'icons';
		var start = 0;
		var ca = document.cookie.split( ';' );
		for ( var i = 0; i < ca.length; i++ ) {
			if ( ca[ i ].indexOf( 'mode=' ) > -1 ) {
				ret = ca[ i ].split( '=' );
				ret = ret[ 1 ].substr( 0, ret[ 1 ].length );
				break;
			}
		}
		return ret;
	}

	// functions to disable / enable fields and fieldsets follow:
	function disableField( tabFields ) {
		var pairs = tabFields.split( ':' );
		var tab = pairs[ 0 ];
		var fields = pairs[ 1 ].split( ',' );
		for ( var i = 0; i < fields.length; i++ ) {
			$(
				'.' +
					fields[ i ] +
					' th, .' +
					fields[ i ] +
					' td, .' +
					fields[ i ] +
					' .description'
			).css( 'color', disabled_color );
			$( '#' + tab + '-' + fields[ i ] ).prop( 'disabled', 'disabled' );
		}
	}

	function enableField( tabFields ) {
		var pairs = tabFields.split( ':' );
		var tab = pairs[ 0 ];
		var fields = pairs[ 1 ].split( ',' );
		for ( var i = 0; i < fields.length; i++ ) {
			$(
				'.' +
					fields[ i ] +
					' th, .' +
					fields[ i ] +
					' td, .' +
					fields[ i ] +
					' .description'
			).removeAttr( 'style' );
			$( '#' + tab + '-' + fields[ i ] ).prop( 'disabled', false );
		}
	}

	function setFilesize() {
		if ( $( '#icons-filesize' ).attr( 'checked' ) ) {
			enableField( 'icons:precision' );
		} else {
			disableField( 'icons:precision' );
		}
	}

	function setMimetypes( init = false ) {
		var allMimetypes = $( '#icons_mimetypes-all_mimetypes' );
		var mimetypeCheckboxes = $(
			'#icons_mimetypes input[type=checkbox]'
		).not( allMimetypes );

		allMimetypes.prop( 'disabled', false );

		if ( allMimetypes.prop( 'checked' ) ) {
			$( '#icons_mimetypes [class^=mimetype_link_icon]' ).css(
				'color',
				disabled_color
			);
			mimetypeCheckboxes.prop( 'checked', true ).prop( 'disabled', true );
		} else if ( init == false ) {
			$( '#icons_mimetypes [class^=mimetype_link_icon]' ).removeAttr(
				'style'
			);
			mimetypeCheckboxes
				.prop( 'checked', false )
				.prop( 'disabled', false );
		}
	}

	function setIconsPreviews() {
		var mode = getCookie();

		switch ( mode ) {
			case 'icons':
				enableField( 'icons:icondimensions,icontype,iconalign' );
				$(
					'input[type=radio][name="rrze-downloads[icons_iconalign]"]'
				).attr( 'disabled', false );
				// Enable tab "File Types Settings":
				$( '#icons_mimetypes-tab' ).fadeIn( 300 );
				break;
			case 'previews':
				disableField( 'icons:icondimensions,icontype' );
				enableField( 'icons:iconalign' );
				$(
					'input[type=radio][name="rrze-downloads[icons_iconalign]"]'
				).attr( 'disabled', false );
				// Enable tab "File Types Settings":
				$( '#icons_mimetypes-tab' ).fadeIn( 300 );
				break;
			case 'plain':
				disableField( 'icons:icondimensions,icontype,iconalign' );
				$(
					'input[type=radio][name="rrze-downloads[icons_iconalign]"]'
				).attr( 'disabled', true );
				// Disable tab "File Types Settings":
				$( '#icons_mimetypes-tab' ).fadeOut( 300 );
				break;
		}
	}

	// click on checkbox "Select all file types"
	$( '#icons_mimetypes-all_mimetypes' ).change( function () {
		setMimetypes();
	} );

	// click on checkbox "Show File Size?"
	$( '#icons-filesize' ).change( function () {
		setFilesize();
	} );

	// click on radiobutton "Icons or Previews"
	$( 'input[type=radio][name="rrze-downloads[icons_icon_preview]"]' ).change(
		function () {
			setCookie(
				$(
					'input[name="rrze-downloads[icons_icon_preview]"]:checked'
				).val()
			);
			setIconsPreviews();
		}
	);

	// default settings will be set on load and after store:
	function onLoaded() {
		setFilesize();
		setMimetypes( true );
		setIconsPreviews();
	}

	onLoaded();
} );
