<?php

namespace RRZE\Downloads\Taxonomies\AttachmentTag;

defined('ABSPATH') || exit;

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
    add_action('pre_get_posts', __NAMESPACE__ . '\\filtering');
    
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

function filtering(\WP_Query $query): void {
    if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== POST_TYPE) {
        return;
    }

    $termId = absint($query->get(TAXONOMY));
    $term = $termId ? get_term($termId, TAXONOMY) : null;
    if (!$term || is_wp_error($term)) {
        return;
    }

    $taxQuery = (array) $query->get('tax_query');
    $taxQuery[] = array(
        'taxonomy' => TAXONOMY,
        'field' => 'term_id',
        'terms' => array($term->term_id),
        'include_children' => false,
    );

    $query->set('tax_query', $taxQuery);
    $query->set(TAXONOMY, '');
}
