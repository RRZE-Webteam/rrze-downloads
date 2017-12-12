<?php

/**
 * Plugin Name:       RRZE Downloads
 * Plugin URI:        https://github.com/RRZE-Webteam/RRZE-Downloads
 * Description:       Bequeme Downloadlisten aus Dateien der Mediathek.
 * Version:           1.4.3
 * Author:            RRZE-Webteam
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 * Text Domain:       rrze-downloads
 * GitHub Plugin URI: https://github.com/RRZE-Webteam/RRZE-Downloads
 * GitHub Branch:     master
 */

namespace RRZE\Downloads;

const RRZE_PHP_VERSION = '5.5';
const RRZE_WP_VERSION = '4.9';

add_action('plugins_loaded', 'RRZE\Downloads\init');
register_activation_hook(__FILE__, 'RRZE\Downloads\activation');

function init() {
    // Sprachdateien werden eingebunden.
    load_textdomain();

    if (is_admin()) {
        require_once('taxonomies/media-taxonomies.php');
        new Taxonomies\Media();
    }    
    require_once('taxonomies/attachment-category.php');
    require_once('taxonomies/attachment-tag.php');
    require_once('shortcodes/downloads.php');

    add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\set');
    add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\register');

    add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentTag\set');
    add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentTag\register');

    add_shortcode('download', 'RRZE\Downloads\Shortcodes\downloads');
    add_shortcode('downloads', 'RRZE\Downloads\Shortcodes\downloads');

    add_action('admin_init', 'RRZE\Downloads\mce_external_plugins');
}

// Einbindung der Sprachdateien.
function load_textdomain() {
    load_plugin_textdomain('rrze-downloads', false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
}

/*
 * Wird durchgeführt wenn das Plugin aktiviert wird.
 * @return void
 */

function activation() {
    // Sprachdateien werden eingebunden.
    load_textdomain();

    // Überprüft die minimal erforderliche PHP- u. WP-Version.
    system_requirements();
}

/*
 * Überprüft die minimal erforderliche PHP- u. WP-Version.
 * @return void
 */

function system_requirements() {
    $error = '';

    if (version_compare(PHP_VERSION, RRZE_PHP_VERSION, '<')) {
        $error = sprintf(__('Ihre PHP-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die PHP-Version %s.', 'rrze-downloads'), PHP_VERSION, RRZE_PHP_VERSION);
    }

    if (version_compare($GLOBALS['wp_version'], RRZE_WP_VERSION, '<')) {
        $error = sprintf(__('Ihre Wordpress-Version %s ist veraltet. Bitte aktualisieren Sie mindestens auf die Wordpress-Version %s.', 'rrze-downloads'), $GLOBALS['wp_version'], RRZE_WP_VERSION);
    }

    // Wenn die Überprüfung fehlschlägt, dann wird das Plugin automatisch deaktiviert.
    if (!empty($error)) {
        deactivate_plugins(plugin_basename(__FILE__), FALSE, TRUE);
        wp_die($error);
    }
}

function mce_external_plugins() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_languages', 'RRZE\Downloads\mce_locale');
        add_filter('mce_external_plugins', 'RRZE\Downloads\mce_buttons');
    }
}

function mce_locale($locales) {
    $locales ['rrze-downloads'] = plugin_dir_path ( __FILE__ ) . 'mce/langs.php';
    return $locales;
}

function mce_buttons($plugin_array) {
    $plugin_array['rrzedownloadshortcode'] = plugin_dir_url(__FILE__) . 'mce/shortcode-button.js';
    return $plugin_array;
}
