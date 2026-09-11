<?php

namespace RRZE\Downloads;

//use RRZE\Downloads\Render;

defined('ABSPATH') || exit;

class Blocks
{
    public function __construct()
    {
        add_action('init', [$this, 'rrze_rrze_downloads_block_init'], 100);
//        add_action('wp_enqueue_scripts', [$this, 'rrze_register_style']);
        add_filter('block_categories_all', [$this, 'my_custom_block_category'], 10, 2);
    }

    /**
     * Initializes the block registration and sets up localization.
     */
    public function rrze_rrze_downloads_block_init()
    {
        $this->registerDownloadsBlockAndTranslations();
    }

//    /**
//     * Register the block styles for the frontend.
//     */
//    public function rrze_register_style()
//    {
//        wp_register_style(
//            'rrze-downloads',
//        );
//    }

    /**
     * Registers blocks and localizations.
     */
    private function registerDownloadsBlockAndTranslations(): void
    {
        $downloadsBlockPath = plugin_dir_path(__DIR__) . 'build/block';
        register_block_type($downloadsBlockPath, [
            'render_callback' => [$this, 'renderBlock'],
        ]);
        $scriptHandle       = generate_block_asset_handle(Config::get('block_type'), 'editorScript');

        wp_add_inline_script(
            $scriptHandle,
            'window.rrzeDownloadsTaxonomies = ' . wp_json_encode(Taxonomies::getBlockTaxonomies()) . ';',
            'before'
        );
        wp_add_inline_script(
            $scriptHandle,
            'window.rrzeDownloadsBlockDefaults = ' . wp_json_encode([
                'fileTypes' => Config::getBlockDefaultFileTypeAttributes(),
            ]) . ';',
            'before'
        );

        wp_set_script_translations(
            $scriptHandle,
            'rrze-downloads',
            plugin_dir_path(__DIR__) . 'languages'
        );

        load_plugin_textdomain(
            'rrze-downloads',
            false,
            dirname(plugin_basename(__DIR__)) . '/languages'
        );
    }


    /**
     * Adds custom block category if not already present.
     *
     * @param array   $categories Existing block categories.
     * @param WP_Post $post       Current post object.
     * @return array Modified block categories.
     */
    public function my_custom_block_category($categories, $post)
    {
        // Check if there is already a RRZE category present
        foreach ($categories as $category) {
            if (isset($category['slug']) && $category['slug'] === 'rrze') {
                return $categories;
            }
        }

        $custom_category = [
            'slug'  => 'rrze',
            'title' => __('RRZE Plugins', 'rrze-downloads'),
        ];

        // Add RRZE to the end of the categories array
        $categories[] = $custom_category;

        return $categories;
    }

    /**
     * Renders the Block via PHP as dynamic block using the shortcode
     * @param $
     * @return string
     */
    public function renderBlock($attributes) {
        $default_atts = array(
            'category' => '',
            'document' => '',
            "cat" => '',
            'tags'               => '',
            'type'               => '',
            'format'             => 'liste',
            'htmlpre'            => '',
            'htmlpost'           => '',
            'htmlitempre'        => '',
            'htmlitempost'       => '',
            'search_application' => false,
            'search_image'       => false,
            'search_video'       => false,
            'search_audio'       => false,
            'search_text'        => false,
            'showsize'           => false,
            'showcreated'        => false,
            'showexcerpt'        => false,
            'showcontent'        => false,
            'errormsg'           => '',
            'orderby'            => 'title',
            'sort'               => 'asc'
        );

        $attributes = shortcode_atts($default_atts, $attributes, 'downloads');

        if (!$this->hasSelectedFileType($attributes)) {
            $attributes = array_merge($attributes, Config::getBlockDefaultFileTypeAttributes());
        }

        $shortcodeInstance = new \RRZE\Downloads\Shortcode();
        return $shortcodeInstance->shortcodeOutput($attributes);
    }

    private function hasSelectedFileType(array $attributes): bool {
        foreach (Config::get('block_file_types')['all'] as $attribute) {
            if (isset($attributes[$attribute]) && filter_var($attributes[$attribute], FILTER_VALIDATE_BOOLEAN)) {
                return true;
            }
        }

        return false;
    }
}
