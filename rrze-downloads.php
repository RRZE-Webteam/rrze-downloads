<?php

/*
Plugin Name:     RRZE Downloads
Plugin URI:      https://github.com/RRZE-Webteam/rrze-downloads
Description:     this will add a list with available download files. Shortcode is [downloads] - see settings for additional attributes
Version:         2.2.14
Author:          RRZE Webteam
Author URI:      https://blogs.fau.de/webworking/
License:         GNU General Public License v2
License URI:     http://www.gnu.org/licenses/gpl-2.0.html
Domain Path:     /languages
Text Domain:     rrze-downloads
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

const RRZE_PHP_VERSION = '8.1';
const RRZE_WP_VERSION = '6.4';

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

    if (file_exists($file)) {
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
    load_plugin_textdomain('rrze-downloads', false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
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
}

/**
 * Wird durchgeführt, nachdem das Plugin deaktiviert wurde.
 */
function deactivation() {
    // Hier können die Funktionen hinzugefügt werden, die
    // bei der Deaktivierung des Plugins aufgerufen werden müssen.
    // Bspw. delete_option, wp_clear_scheduled_hook, flush_rewrite_rules, etc.
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
        });
        
        // Das Plugin wird nicht mehr ausgeführt.
        return;
    }

    if (is_admin()) {
        require_once('assets/taxonomies/media-taxonomies.php');
        new Taxonomies\Media();
    }    
    require_once('assets/taxonomies/attachment-category.php');
    require_once('assets/taxonomies/attachment-tag.php');

    add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\set');
    add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\register');

    add_action('init', 'RRZE\Downloads\Taxonomies\AttachmentTag\set');
    add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentTag\register');

    $main = new Main(__FILE__);
    $main->onLoaded();
}
