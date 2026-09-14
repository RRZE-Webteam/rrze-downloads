<?php

/*
Plugin Name:     RRZE Downloads
Plugin URI:      https://github.com/RRZE-Webteam/rrze-downloads
Description:     RRZE Downloads: Manage Categories for the WP Media Library
Version:         2.3.0
Requires at least: 6.8
Requires PHP:    8.2
Author:          RRZE Webteam (webmaster@fau.de)
Author URI:      https://www.wp.rrze.fau.de/
License:         GNU General Public License Version 3
License URI:     https://www.gnu.org/licenses/gpl-3.0.html
Domain Path:     /languages
Text Domain:     rrze-downloads
*/

namespace RRZE\Downloads;


defined('ABSPATH') || exit;


// Laden der Konfigurationsdateien
require_once __DIR__ . '/includes/Config.php';

use RRZE\Downloads\Main;

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
    load_plugin_textdomain(Config::get('text_domain'), false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
}

/**
 * Überprüft die Systemvoraussetzungen.
 */
function systemRequirements() {
    $error = '';
    if (version_compare(PHP_VERSION, Config::get('required_php_version'), '<')) {
        /* translators: 1: current PHP version, 2: required PHP version. */
        $error = sprintf(__('The server is running PHP version %1$s. The Plugin requires at least PHP version %2$s.', 'rrze-downloads'), PHP_VERSION, Config::get('required_php_version'));
    } elseif (version_compare($GLOBALS['wp_version'], Config::get('required_wp_version'), '<')) {
        /* translators: 1: current WordPress version, 2: required WordPress version. */
        $error = sprintf(__('The server is running WordPress version %1$s. The Plugin requires at least WordPress version %2$s.', 'rrze-downloads'), $GLOBALS['wp_version'], Config::get('required_wp_version'));
    }
    return $error;
}

/**
 * Wird nach der Aktivierung des Plugins ausgeführt.
 */
function activation() {
    // Sprachdateien werden eingebunden.
    loadTextDomain();

    if ($error = systemRequirements()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(esc_html($error));
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
                /* translators: 1: plugin name, 2: error message. */
                $message = __('Plugins: %1$s: %2$s', 'rrze-downloads');
                printf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    esc_html($message),
                    esc_html($pluginName),
                    esc_html($error)
                );
            });
        });
        
        // Das Plugin wird nicht mehr ausgeführt.
        return;
    }

    $taxonomies = new Taxonomies();
    $taxonomies->loaded();

    $main = new Main(__FILE__);
    $main->onLoaded();
}
