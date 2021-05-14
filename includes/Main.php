<?php

namespace RRZE\Downloads;

defined('ABSPATH') || exit;

use RRZE\Downloads\Settings;

  /**
 * Hauptklasse (Main)
 */
class Main {
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

        remove_filter('the_content', 'wpautop');
        add_filter('the_content', 'wpautop', 12);
    }

    /**
     * Es wird ausgeführt, sobald die Klasse instanziiert wird.
     */
    public function onLoaded() {

      // Settings-Klasse wird instanziiert.
      $settings = new Settings($this->pluginFile);
      $settings->onLoaded();

      // Shortcode wird eingebunden.
      include 'Shortcode.php';
      $shortcode = new Shortcode();
    }
}