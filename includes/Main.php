<?php

namespace RRZE\Downloads;

defined('ABSPATH') || exit;

use RRZE\Downloads\Settings;


class Main {
    protected $pluginFile;


    public function __construct($pluginFile) {
        $this->pluginFile = $pluginFile;

    }


    public function onLoaded() {
      $settings = new Settings($this->pluginFile);
      $settings->onLoaded();

      // Shortcode wird eingebunden.
      include 'Shortcode.php';
      $shortcode = new Shortcode();

      new Blocks();
    }
}