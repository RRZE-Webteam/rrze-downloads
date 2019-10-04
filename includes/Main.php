<?php

namespace RRZE\Downloads;

defined('ABSPATH') || exit;

use RRZE\Downloads\Settings;

 
 /**
 * Hauptklasse (Main)
 */
class Main
{
    /**
     * Der vollständige Pfad- und Dateiname der Plugin-Datei.
     * @var string
     */
    protected $pluginFile;

    /**
     * Variablen Werte zuweisen.
     * @param string $pluginFile Pfad- und Dateiname der Plugin-Datei
     */
    public function __construct($pluginFile) {
        $this->pluginFile = $pluginFile;
    }

    /**
     * Es wird ausgeführt, sobald die Klasse instanziiert wird.
     */
    public function onLoaded() {


      add_action('enqueue_block_assets', function () {
        
        wp_enqueue_script(
        		'rrze-downloads-js',
        		plugins_url( "/blocks/downloads/index.js", __FILE__ ),
        		[ 'wp-i18n' ],
        		filemtime( __DIR__ . "/blocks/downloads/index.js" )
        	);

        	if ( function_exists( 'gutenberg_get_jed_locale_data' ) ) {
        		$locale  = gutenberg_get_jed_locale_data( 'text-domain' );
        		$content = 'wp.i18n.setLocaleData( ' . json_encode( $locale ) . ', "rrze-downloads" );';
        		wp_script_add_data( 'rrze-downloads-js', 'data', $content );
        	}
                  
        // wp_enqueue_script(
        //       'rrze-downloads-js',
        //       ['wp-blocks', 'wp-i18n', 'wp-element' , 'wp-components' , 'wp-editor'], null
        //   ); 
      });      

      // Settings-Klasse wird instanziiert.
      $settings = new Settings($this->pluginFile);
      $settings->onLoaded();

      // Shortcode wird eingebunden.
      include 'Shortcode.php';
    
    }
}
