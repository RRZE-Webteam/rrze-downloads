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

        // wp_enqueue_script(
        //     'rrze-downloads-js',
        //     ['wp-blocks', 'wp-i18n', 'wp-element' , 'wp-components' , 'wp-editor'], null
        // ); 
      // add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

      // Settings-Klasse wird instanziiert.
      $settings = new Settings($this->pluginFile);
      $settings->onLoaded();

      // Shortcode wird eingebunden.
      include 'Shortcode.php';
    
    }
}
