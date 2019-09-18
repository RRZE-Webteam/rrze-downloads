<?php

/*
Plugin Name:     RRZE Downloads
Plugin URI:      https://gitlab.rrze.fau.de/rrze-webteam/rrze-downloads
Description:     this will add a list with available download files. Shortcode is [downloads] - see settings for additional attributes
Version:         2.0.0
Author:          RRZE Webteam
Author URI:      https://blogs.fau.de/webworking/
License:         GNU General Public License v2
License URI:     http://www.gnu.org/licenses/gpl-2.0.html
Domain Path:     /languages
Text Domain:     rrzw-downloads
*/

namespace RRZE\Downloads;

/*
Die Codezeile defined('ABSPATH') || exit;
verhindert den direkten Zugriff auf die PHP-Dateien über URL und stellt sicher,
dass die Plugin-Dateien nur innerhalb der WordPress-Umgebung ausgeführt werden.
Denn wenn bspw. eine Datei I/O-Operationen enthält,
kann sie schließlich kompromittiert werden (durch einen Angreifer),
was zu unerwartetem Verhalten führen kann.
*/
defined('ABSPATH') || exit;


// Laden der Konfigurationsdatei
require_once 'config/config.php';

use RRZE\Downloads\Main;

const RRZE_PHP_VERSION = '5.5';
const RRZE_WP_VERSION = '4.9';


// Automatische Laden von Klassen.
spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__;
    $base_dir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relativeClass) . '.php';

    error_log('BK new $file = '. $file);

    if (file_exists($file)) {
      error_log('BK new exists');
        require $file;
    }
});

// Registriert die Plugin-Funktion, die bei Aktivierung des Plugins ausgeführt werden soll.
register_activation_hook(__FILE__, __NAMESPACE__ . '\activation');
// Registriert die Plugin-Funktion, die ausgeführt werden soll, wenn das Plugin deaktiviert wird.
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivation');
// Wird aufgerufen, sobald alle aktivierten Plugins geladen wurden.
add_action('plugins_loaded', __NAMESPACE__ . '\loaded');

/**
 * Einbindung der Sprachdateien.
 */
function loadTextDomain() {
    load_plugin_textdomain('rrzw-downloads', false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
}

/**
 * Überprüft die Systemvoraussetzungen.
 */
function systemRequirements() {
    $error = '';
    if (version_compare(PHP_VERSION, RRZE_PHP_VERSION, '<')) {
        /* Übersetzer: 1: aktuelle PHP-Version, 2: erforderliche PHP-Version */
        $error = sprintf(__('The server is running PHP version %1$s. The Plugin requires at least PHP version %2$s.', 'rrze-downloads'), PHP_VERSION, RRZE_PHP_VERSION);
    } elseif (version_compare($GLOBALS['wp_version'], RRZE_WP_VERSION, '<')) {
        /* Übersetzer: 1: aktuelle WP-Version, 2: erforderliche WP-Version */
        $error = sprintf(__('The server is running WordPress version %1$s. The Plugin requires at least WordPress version %2$s.', 'rrze-downloads'), $GLOBALS['wp_version'], RRZE_WP_VERSION);
    }
    return $error;
}

/**
 * Wird nach der Aktivierung des Plugins ausgeführt.
 */
function activation() {
    // Sprachdateien werden eingebunden.
    loadTextDomain();

    // Überprüft die minimal erforderliche PHP- u. WP-Version.
    // Wenn die Überprüfung fehlschlägt, dann wird das Plugin automatisch deaktiviert.
    if ($error = systemRequirements()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die($error);
    }

    // Ab hier können die Funktionen hinzugefügt werden,
    // die bei der Aktivierung des Plugins aufgerufen werden müssen.
    // Bspw. wp_schedule_event, flush_rewrite_rules, etc.
}

/**
 * Wird durchgeführt, nachdem das Plugin deaktiviert wurde.
 */
function deactivation() {
    // Hier können die Funktionen hinzugefügt werden, die
    // bei der Deaktivierung des Plugins aufgerufen werden müssen.
    // Bspw. delete_option, wp_clear_scheduled_hook, flush_rewrite_rules, etc.
}


function mce_external_plugins() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_languages', 'RRZE\Downloads\mce_locale');
        add_filter('mce_external_plugins', 'RRZE\Downloads\mce_buttons');
    }
}

function mce_locale($locales) {
    $locales ['rrze-downloads'] = plugin_dir_path ( __FILE__ ) . 'assets/mce-langs.php';
    return $locales;
}

function mce_buttons($plugin_array) {
    $plugin_array['rrzedownloadshortcode'] = plugin_dir_url(__FILE__) . 'assets/js/shortcode-button.js';
    return $plugin_array;
}

/**
 * Wird durchgeführt, nachdem das WP-Grundsystem hochgefahren
 * und alle Plugins eingebunden wurden.
 */
function loaded() {
    // Sprachdateien werden eingebunden.
    loadTextDomain();

    // Überprüft die Systemvoraussetzungen.
    if ($error = systemRequirements()) {
        add_action('admin_init', function () use ($error) {
            $pluginData = get_plugin_data(__FILE__);
            $pluginName = $pluginData['Name'];
            $tag = is_plugin_active_for_network(plugin_basename(__FILE__)) ? 'network_admin_notices' : 'admin_notices';


            add_action($tag, function () use ($pluginName, $error) {
                printf(
                    '<div class="notice notice-error"><p>' . __('Plugins: %1$s: %2$s', 'rrze-downloads') . '</p></div>',
                    esc_html($pluginName),
                    esc_html($error)
                );
            });
            require_once('assets/taxonomies/media-taxonomies.php');
            new Taxonomies\Media();
        });
        
        require_once('assets/taxonomies/attachment-category.php');
        require_once('assets/taxonomies/attachment-tag.php');
        
        add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\set');
        add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentTag\set');

        add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\register');
        add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentTag\register');
        add_action('admin_init', 'RRZE\Downloads\mce_external_plugins');
        
        // Das Plugin wird nicht mehr ausgeführt.
        return;
    }


    // Hauptklasse (Main) wird instanziiert.
    $main = new Main(__FILE__);
    $main->onLoaded();
}
