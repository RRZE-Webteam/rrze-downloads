<?php

/*
  Plugin Name: RRZE-Downloads
  Plugin URI: https://github.com/RRZE-Webteam/RRZE-Downloads
  Version: 1.1.0
  Description: Bequeme Downloadlisten aus Dateien der Mediathek
  Author: RRZE-Webteam
  Author URI: http://blogs.fau.de/webworking/
  Network:
 */

/*
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */


add_action('plugins_loaded', array('RRZE_Downloads', 'instance'));

register_activation_hook(__FILE__, array('RRZE_Downloads', 'activation'));
register_deactivation_hook(__FILE__, array('RRZE_Downloads', 'deactivation'));
require_once('shortcodes/rrze-downloads-shortcodes.php');     

/*
 * rrze-downloads-Klasse
 */

class RRZE_Downloads {
   
    const option_name = 'RRZE-Downloads';
    const textdomain = 'rrze-downloads';
    const php_version = '5.3';
    const wp_version = '4.5';

    protected static $options;
    protected $admin_settings_page;
    protected static $instance = null;


    public static function instance() {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    private function __construct() {
        // Sprachdateien werden eingebunden.
        load_plugin_textdomain(self::textdomain, false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));

        // Enthaltene Optionen.
        self::$options = self::get_options();
        
	
	include_once(plugin_dir_path(__FILE__) . 'taxonomies/attachment-category.php');
	include_once(plugin_dir_path(__FILE__) . 'taxonomies/attachment-tag.php');

	add_action('admin_init', array($this, 'downloads_shortcodes_rte_button'));
	self::add_shortcodes();        
    }


    public static function activation() {
        // Überprüft die minimal erforderliche PHP- u. WP-Version.
        self::version_compare();
    }

    public static function deactivation() {
    }


    public static function version_compare() {
        $error = '';

        if (version_compare(PHP_VERSION, self::php_version, '<')) {
            $error = sprintf(__('Ihre PHP-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die PHP-Version %s.', self::textdomain), PHP_VERSION, self::php_version);
        }

        if (version_compare($GLOBALS['wp_version'], self::wp_version, '<')) {
            $error = sprintf(__('Ihre Wordpress-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die Wordpress-Version %s.', self::textdomain), $GLOBALS['wp_version'], self::wp_version);
        }

        // Wenn die Überprüfung fehlschlägt, dann wird das Plugin automatisch deaktiviert.
        if (!empty($error)) {
            deactivate_plugins(plugin_basename(__FILE__), false, true);
            wp_die($error);
        }
    }

    /*
     * Standard Einstellungen werden definiert
     * @return array
     */
    private static function default_options() {
        $options = array(  );

        return $options;
    }

    /*
     * Gibt die Einstellungen zurück.
     * @return object
     */
    private static function get_options() {
        $defaults = self::default_options();

        $options = (array) get_option(self::option_name);
        $options = wp_parse_args($options, $defaults);
        $options = array_intersect_key($options, $defaults);

        return (object) $options;
    }
        
    
    public function downloads_shortcodes_rte_button() {
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
            add_filter( 'mce_external_plugins', array($this, 'downloads_rte_add_buttons' ));
        }
    }

    public function downloads_rte_add_buttons( $plugin_array ) {
        $plugin_array['downloadrteshortcodes'] = plugin_dir_url(__FILE__) . 'js/tinymce-shortcodes.js';
        return $plugin_array;
    }

    private static function add_shortcodes() {     
        add_shortcode('download', 'rrze_downloads' );
        add_shortcode('downloads', 'rrze_downloads');
    }
    
 

}
