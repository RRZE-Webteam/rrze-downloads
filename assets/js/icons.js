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

  function setCookie( cookie ) {
    document.cookie = cookie;
  }

  function getCookie() {
    ret = 'hide';
    if (document.cookie) {
      var start = document.cookie.indexOf('tab=') + 4;
      if (start > 4) {
        var end = document.cookie.indexOf(';'); 
        ret = document.cookie.substring(start, end);
      }
    }
    return ret;
  }


  function toggleTab() {
    vis = getCookie();
    if ( vis == 'show' ) {
      // Enable tab "File Types Settings":
      $( '#icons_mimetypes-tab' ).removeAttr( 'style' );
      $( '#icons_mimetypes-tab' ).unbind( 'click', eventhandler);
    } else {
      // Disable tab "File Types Settings":
      $( '#icons_mimetypes-tab' ).css( {'color': disabled_color, 'cursor': 'default'} );
      $( '#icons_mimetypes-tab' ).bind( 'click', eventhandler );
    }
  }

  // functions to disable / enable fields and fieldsets follow:  
  function disableField( tab, field ) {
    $( '.' + field + ' th, .' + field + ' td, .' + field + ' .description').css( "color", disabled_color);
    $( '#' + tab + '-' + field ).prop('disabled', 'disabled');
  }

  function enableField( tab, field ) {
    $( '.' + field + ' th, .' + field + ' td, .' + field + ' .description').removeAttr( 'style' );
    $( '#' + tab + '-' + field ).prop('disabled', false );
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

  function setFilesize() {
    if ( $( '#additional-filesize' ).attr('checked') ) {
      enableField( 'additional', 'precision' );  
      enableField( 'additional', 'cache' );  
      enableField( 'additional', 'cachetime' );  
    } else {
      disableField( 'additional', 'precision' );  
      disableField( 'additional', 'cache' );  
      disableField( 'additional', 'cachetime' );  
      $( '#additional-cache' ).attr('checked', false);
    }
  }

  function setReplacement() {
    if ( $( 'input[type=radio][name="rrze_downloads[additional_replacement]"]:checked' ).val() == 'asynchronous' ) {
      enableField( 'additional', 'asynchronous_debug' );  
    } else {
      $( '#additional-asynchronous_debug' ).attr('checked', false);
      disableField( 'additional', 'asynchronous_debug' );  
    }
  }

  function setClassnames() {
    
    if ( $( '#additional-enable_classnames' ).attr('checked') ) {
      enableField( 'additional', 'classnames' );  
    } else {
      disableField( 'additional', 'classnames' );  
    }
  }
  
  function setIconsPreviews() {
    if ( $( 'input[name="rrze_downloads[icons_icon-preview]"]:checked' ).val() == 'previews' ) {
      // "Previews" has been selected -> Disable options for icons:
      disableField( 'icons', 'iconsize' );  
      disableField( 'icons', 'icontype' );  
      disableField( 'icons', 'iconalign' );  
      $( 'input[type=radio][name="rrze_downloads[icons_iconalign]"]' ).attr( 'disabled', true );
      setCookie( 'tab=hide;' );
    } else {
      // "Icons" has been selected -> Enable options for icons:
      enableField( 'icons', 'iconsize' );
      enableField( 'icons', 'icontype' );
      enableField( 'icons', 'iconalign' );
      $( 'input[type=radio][name="rrze_downloads[icons_iconalign]"]' ).attr( 'disabled', false );
      setCookie( 'tab=show;' );
    }
    toggleTab();
  }

  // click on checkbox "Select all file types"
  $( '#icons_mimetypes-all_mimetypes' ).change( function() {
    setMimetypes();
  });
  
  // click on checkbox "Enable classnames?"
  $( '#additional-enable_classnames' ).change( function() {
    setClassnames();
  });


  // click on checkbox "Show File Size?"
  $( '#additional-filesize' ).change( function() {
    setFilesize();
  });

  // click on radiobutton "Replacement Mode"
  $( 'input[type=radio][name="rrze_downloads[additional_replacement]' ).change( function() {
    setReplacement();
  });

  // click on radiobutton "Icons or Previews" 
  $( 'input[type=radio][name="rrze_downloads[icons_icon-preview]"]' ).change( function() {
    setIconsPreviews();
  });


  // default settings will be set on load and after store:
  function onLoaded() {
    setClassnames();
    setFilesize();
    setReplacement();
    setMimetypes(true);
    setIconsPreviews();
  }

  onLoaded();
  
});


