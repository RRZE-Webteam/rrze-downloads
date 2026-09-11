<?php

namespace RRZE\Downloads\Taxonomies\AttachmentTag;

define(__NAMESPACE__ . '\POST_TYPE', \RRZE\Downloads\Config::get('attachment_post_type'));
define(__NAMESPACE__ . '\TAXONOMY', \RRZE\Downloads\Config::get('attachment_tag_taxonomy'));

function set() {
    $labels = array(
        'name' => __('Tags', 'rrze-downloads'),
        'singular_name' => __('Tag', 'rrze-downloads'),
        'search_items' => __('Search Tags', 'rrze-downloads'),
        'popular_items' => __('Popular Tags', 'rrze-downloads'),
        'all_items' => __('All Tags', 'rrze-downloads'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Tag', 'rrze-downloads'),
        'update_item' => __('Update Tag', 'rrze-downloads'),
        'add_new_item' => __('Add New Tag', 'rrze-downloads'),
        'new_item_name' => __('Name', 'rrze-downloads'),
        'separate_items_with_commas' => __('Separate tags with commas', 'rrze-downloads'),
        'add_or_remove_items' => __('Add or remove tags', 'rrze-downloads'),
        'choose_from_most_used' => __('Choose from the most used tags', 'rrze-downloads'),
        'menu_name' => __('Tags', 'rrze-downloads')
    );

    register_taxonomy(TAXONOMY, POST_TYPE, array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => TAXONOMY),
        'update_count_callback' => '_update_generic_term_count',
        'capabilities' => array (
            'manage_terms' => 'manage_options',
            'edit_terms' => 'manage_options',
            'delete_terms' => 'manage_options',
            'assign_terms' => 'edit_attachment'
        )
    ));
}


function register() {
    register_taxonomy_for_object_type(TAXONOMY, POST_TYPE);
    add_action('restrict_manage_posts', 'RRZE\Downloads\Taxonomies\AttachmentTag\filter_list');
    add_filter('parse_query', 'RRZE\Downloads\Taxonomies\AttachmentTag\filtering');
    
}

function filter_list() {
    global $wp_query;
    $screen = get_current_screen();
    if ($screen->parent_file == 'upload.php' && get_terms(TAXONOMY)) {
        wp_dropdown_categories(array(
            'show_option_all' => __('All Tags', 'rrze-downloads'),
            'taxonomy' => TAXONOMY,
            'name' => TAXONOMY,
            'orderby' => 'name',
            'selected' => ( isset($wp_query->query[TAXONOMY]) ? $wp_query->query[TAXONOMY] : '' ),
            'hierarchical' => false,
            'show_count' => true,
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
