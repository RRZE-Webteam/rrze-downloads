jQuery(document).ready(function($) {
  
  var eventhandler = function(e) {
     e.preventDefault();      
  }
  
  var disabled_color = '#b4b9be';


  function disableField( tab, field ) {
    $( '.' + field + ' th, .' + field + ' td, .' + field + ' .description').css( "color", disabled_color);
    $( '#' + tab + '-' + field ).prop('disabled', 'disabled');
  }

  function enableField( tab, field ) {
    $( '.' + field + ' th, .' + field + ' td, .' + field + ' .description').removeAttr( 'style' );
    $( '#' + tab + '-' + field ).prop('disabled', false );
  }
  
  // click on checkbox "Enable classnames?"
  $( '#additional-enable_classnames' ).change( function() {
    if ( $( '#additional-enable_classnames' ).attr('checked') ) {
      enableField( 'additional', 'classnames');  
    } else {
      disableField( 'additional', 'classnames');  
    }
  });

  // click on checkbox "Show File Size?"
  $( '#additional-filesize' ).change( function() {
    if ( $( '#additional-filesize' ).attr('checked') ) {
      enableField( 'additional', 'precision');  
      enableField( 'additional', 'cache');  
      enableField( 'additional', 'cachetime');  
    } else {
      disableField( 'additional', 'precision');  
      disableField( 'additional', 'cache');  
      disableField( 'additional', 'cachetime');  
    }
  });

  // click on radiobutton "Replacement Mode"
  $( 'input[type=radio][name="rrze_downloads[additional_replacement]' ).change( function() {
    if ( $( 'input[type=radio][name="rrze_downloads[additional_replacement]"]:checked' ).val() == 'asynchronous'  ) {
      enableField( 'additional', 'asynchronous_debug');  
    } else {
      disableField( 'additional', 'asynchronous_debug');  
    }
  });

  // click on radiobutton "Icons or Previews" 
  $( 'input[type=radio][name="rrze_downloads[icons_icon-preview]"]' ).change( function() {
    if ( $( 'input[name="rrze_downloads[icons_icon-preview]"]:checked' ).val() == 'previews' ) {
      // "Previews" has been selected
      // Disable tab "File Types Settings":
      $( '#icons_mimetypes-tab' ).css( {'color': disabled_color, 'cursor': 'default'} );
      $( '#icons_mimetypes-tab' ).bind( 'click', eventhandler);
      // Disable options for icons:
      disableField( 'icons', 'iconsize');  
      disableField( 'icons', 'icontype');  
      disableField( 'icons', 'iconalign');  
      $( 'input[type=radio][name="rrze_downloads[icons_iconalign]"]' ).attr( 'disabled', true );
    } else {
      // "Icons" has been selected
      // Enable tab "File Types Settings":
      $( '#icons_mimetypes-tab' ).removeAttr( 'style' );
      $( '#icons_mimetypes-tab' ).unbind( 'click', eventhandler);
      // Enable options for icons:
      enableField( 'icons', 'iconsize' );
      enableField( 'icons', 'icontype' );
      enableField( 'icons', 'iconalign' );
      $( 'input[type=radio][name="rrze_downloads[icons_iconalign]"]' ).attr( 'disabled', false );
      // $( '.iconsize th' ).removeAttr( 'style' );

//      $( '.iconsize th, .iconsize .description, .icontype th, .icontype .description, .iconalign th, .iconalign td, .iconalign .description' ).removeAttr( 'style' );
    }
  });

  function onLoaded() {
    disableField( 'additional', 'classnames' );  
    disableField( 'additional', 'precision' );  
    disableField( 'additional', 'cache' );  
    disableField( 'additional', 'cachetime' );  
    disableField( 'additional', 'asynchronous_debug' );  
  }

  
  // default settings will be set here:
  onLoaded();
});