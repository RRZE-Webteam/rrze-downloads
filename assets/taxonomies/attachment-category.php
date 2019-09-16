<?php

namespace RRZE\Downloads\Taxonomies\AttachmentCategory;

const POST_TYPE = 'attachment';
const TAXONOMY = 'attachment_category';

function set() {
    $labels = array(
        'name' => __('Kategorien', 'rrze-downloads'),
        'singular_name' => __('Kategorie', 'rrze-downloads'),
        'search_items' => __('Kategorien suchen', 'rrze-downloads'),
        'all_items' => __('Alle Kategorien', 'rrze-downloads'),
        'parent_item' => __('Übergeordnet', 'rrze-downloads'),
        'parent_item_colon' => __('Übergeordnet:', 'rrze-downloads'),
        'edit_item' => __('Kategorie bearbeiten', 'rrze-downloads'),
        'update_item' => __('Kategorie aktualisieren', 'rrze-downloads'),
        'add_new_item' => __('Neue Kategorie hinzufügen', 'rrze-downloads'),
        'new_item_name' => __('Name', 'rrze-downloads'),
        'menu_name' => __('Kategorien', 'rrze-downloads')
    );

    register_taxonomy(TAXONOMY, POST_TYPE, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'query_var' => true,
        'rewrite' => array('slug' => TAXONOMY),
        'update_count_callback' => '_update_generic_term_count',
        'capabilities' => array (
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_attachment'
        )
    ));
}

function register() {
    register_taxonomy_for_object_type(TAXONOMY, POST_TYPE);
    
    add_action('restrict_manage_posts', 'RRZE\Downloads\Taxonomies\AttachmentCategory\filter_list');
    add_filter('parse_query', 'RRZE\Downloads\Taxonomies\AttachmentCategory\filtering');
    
    add_action('admin_enqueue_scripts', 'RRZE\Downloads\Taxonomies\AttachmentCategory\media_category_enqueue_media_action');
}

function filter_list() {
    global $wp_query;
    $screen = get_current_screen();
    if ($screen->parent_file == 'upload.php' && get_terms(TAXONOMY)) {
        wp_dropdown_categories(array(
            'show_option_all' => __('Alle Kategorien', 'rrze-downloads'),
            'taxonomy' => TAXONOMY,
            'name' => TAXONOMY,
            'orderby' => 'name',
            'selected' => (isset($wp_query->query[TAXONOMY]) ? $wp_query->query[TAXONOMY] : ''),
            'hierarchical' => true,
            'depth' => 6,
            'show_count' => false,
            'hide_empty' => true,
        ));
    }
}

function filtering($query) {
    $qv = &$query->query_vars;
    if (!empty($qv[TAXONOMY]) && is_numeric($qv[TAXONOMY])) {
        $term = get_term_by('id', $qv[TAXONOMY], TAXONOMY);
        $qv[TAXONOMY] = $term->slug;
    }
}

function media_category_enqueue_media_action() {
    global $pagenow, $wp_query;
    
    if (wp_script_is('media-editor') && 'upload.php' == $pagenow) {

        $dropdown_options = array(
            'taxonomy' => TAXONOMY,
            'hide_empty' => true,
            'hierarchical' => true,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[TAXONOMY]) ? $wp_query->query[TAXONOMY] : '',
            'show_count' => false,
            'walker' => new media_category_grid_view_walker(),
            'value' => 'id',
            'echo' => false
        );

        $attachment_terms = wp_dropdown_categories($dropdown_options);
        $attachment_terms = preg_replace(array("/<select([^>]*)>/", "/<\/select>/"), "", $attachment_terms);

        echo '<script type="text/javascript">';
        echo '/* <![CDATA[ */';
        echo 'var attachment_category = {"' . TAXONOMY . '":{"list_title":"' . html_entity_decode(__('Alle Kategorien', 'rrze-downloads'), ENT_QUOTES, 'UTF-8') . '","term_list":[' . substr($attachment_terms, 2) . ']}};';
        echo '/* ]]> */';
        echo '</script>';
    }

}

class media_category_grid_view_walker extends \Walker_CategoryDropdown {

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $cat_name = apply_filters('list_cats', $category->name, $category);

        $output .= ',{"term_id":"' . $category->term_id . '",';

        $output .= '"term_name":"' . $pad . esc_attr($cat_name);
        if ($args['show_count']) {
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        }
        $output .= '"}';
    }

}