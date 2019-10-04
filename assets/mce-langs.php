<?php

namespace RRZE\Downloads\MCE\Langs;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('_WP_Editors')) {
    require(ABSPATH . WPINC . '/class-wp-editor.php');
}

function mce_plugin_translation() {
    $strings = array(
        'adddownloadlist' => __('Downloadliste einfügen', 'rrze-downloads'),
    );
    $locale = \_WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.rrze-downloads_mce_plugin", ' . json_encode($strings) . ");\n";

    return $translated;
}

$strings = mce_plugin_translation();
