jQuery(document).ready(function($) {
  var eventhandler = function(e) {
     e.preventDefault();      
  }
  
  var disabled_color = '#b4b9be';

  function strcmp(a, b) {
    if (a.toString() < b.toString()) return -1;
    if (a.toString() > b.toString()) return 1;
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
      if ( ca[i].indexOf( 'mode=' ) > -1 ) {
        ret = ca[i].split( '=' );
        ret = ret[1].substr(0, ret[1].length);
        break;
      }
    }
    return ret;
  }

  // functions to disable / enable fields and fieldsets follow:  
  function disableField( tabFields ) {
    var pairs = tabFields.split( ':' );
    var tab = pairs[0];
    var fields = pairs[1].split( ',' );
    for (var i = 0; i < fields.length; i++ ){
      $( '.' + fields[i] + ' th, .' + fields[i] + ' td, .' + fields[i] + ' .description').css( "color", disabled_color);
      $( '#' + tab + '-' + fields[i] ).prop('disabled', 'disabled');
    }
  }

  function enableField( tabFields ) {
    var pairs = tabFields.split( ':' );
    var tab = pairs[0];
    var fields = pairs[1].split( ',' );
    for (var i = 0; i < fields.length; i++ ){
      $( '.' + fields[i] + ' th, .' + fields[i] + ' td, .' + fields[i] + ' .description').removeAttr( 'style' );
      $( '#' + tab + '-' + fields[i] ).prop('disabled', false );
    }
  }

  function setClassnames() {
    if ( $( '#additional-use_classnames' ).attr('checked') ) {
      enableField( 'additional:classnames' );  
    } else {
      disableField( 'additional:classnames' );  
    }
  }
  
  function setCache() {
    if ( $( '#additional-cache' ).attr('checked') ) {
      enableField( 'additional:cachetime' );  
    } else {
      disableField( 'additional:cachetime' );  
    }
  }

  function setFilesize() {
    if ( $( '#additional-filesize' ).attr('checked') ) {
      enableField( 'additional:precision,cache' ); 
      setCache(); 
    } else {
      disableField( 'additional:precision,cache,cachetime' );  
    }
  }

  function setReplacement() {
    if ( $( 'input[type=radio][name="rrze-downloads[additional_replacement]"]:checked' ).val() == 'asynchronous' ) {
      enableField( 'additional:asynchronous_debug' );  
    } else {
      $( '#additional-asynchronous_debug' ).attr('checked', false);
      disableField( 'additional:asynchronous_debug' );  
    }
  }

  function setMimetypes(init = false) {
    if ( $( '#icons_mimetypes-all_mimetypes' ).attr('checked') ) {
      $( '[class^=mimetype_link_icon], [class^=mimetype_link_icon] th' ).css( "color", disabled_color);
      $( 'input[type=checkbox]' ).each(function () {
        $(this).prop('checked', true);
        var myfield = $(this).attr('id');
        if ( strcmp(myfield, 'icons_mimetypes-all_mimetypes' ) != 0 ) {
          $(this).prop( 'disabled', 'disabled' );
        }
      });      
    } else if (init == false) {
      $( '[class^=mimetype_link_icon], [class^=mimetype_link_icon] th').removeAttr( 'style' );
      $( 'input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
        var myfield = $(this).attr('id');
        if ( strcmp(myfield, 'icons_mimetypes-all_mimetypes') != 0 ) {
          $(this).prop('disabled', false );
        }
      });      
    }
  }

  function setIconsPreviews() {
    var mode = getCookie();

    switch (mode) {
      case 'icons':
        enableField( 'icons:icondimensions,icontype,iconalign' );  
        $( 'input[type=radio][name="rrze-downloads[icons_iconalign]"]' ).attr( 'disabled', false );
        // Enable tab "File Types Settings":
        $( '#icons_mimetypes-tab' ).removeAttr( 'style' );
        $( '#icons_mimetypes-tab' ).unbind( 'click', eventhandler);
        break;
      case 'previews':
        disableField( 'icons:icondimensions,icontype' );  
        enableField( 'icons:iconalign' );  
        $( 'input[type=radio][name="rrze-downloads[icons_iconalign]"]' ).attr( 'disabled', false );
        // Disable tab "File Types Settings":
        $( '#icons_mimetypes-tab' ).css( {'color': disabled_color, 'cursor': 'default'} );
        $( '#icons_mimetypes-tab' ).bind( 'click', eventhandler );
        break;
      case 'plain':
        disableField( 'icons:icondimensions,icontype,iconalign' );  
        $( 'input[type=radio][name="rrze-downloads[icons_iconalign]"]' ).attr( 'disabled', true );
        // Disable tab "File Types Settings":
        $( '#icons_mimetypes-tab' ).css( {'color': disabled_color, 'cursor': 'default'} );
        $( '#icons_mimetypes-tab' ).bind( 'click', eventhandler );
        break;
    }
  }

  // click on checkbox "Select all file types"
  $( '#icons_mimetypes-all_mimetypes' ).change( function() {
    setMimetypes();
  });
  
  // click on checkbox "Enable classnames?"
  $( '#additional-use_classnames' ).change( function() {
    setClassnames();
  });


  // click on checkbox "Show File Size?"
  $( '#additional-filesize' ).change( function() {
    setFilesize();
  });

  // click on checkbox "Cache retrieved file sizes."
  $( '#additional-cache' ).change( function() {
    setCache();
  });

  // click on radiobutton "Replacement Mode"
  $( 'input[type=radio][name="rrze-downloads[additional_replacement]' ).change( function() {
    setReplacement();
  });

  // click on radiobutton "Icons or Previews" 
  $( 'input[type=radio][name="rrze-downloads[icons_icon_preview]"]' ).change( function() {
    setCookie( $( 'input[name="rrze-downloads[icons_icon_preview]"]:checked' ).val() );
    setIconsPreviews();
  });



  // default settings will be set on load and after store:
  function onLoaded() {
    setClassnames();
    setFilesize();
    setCache();
    setReplacement();
    setMimetypes( true );
    setIconsPreviews();
  }

  onLoaded();  
});


