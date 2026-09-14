<?php

namespace RRZE\Downloads\Taxonomies\AttachmentDocument;

defined('ABSPATH') || exit;

define(__NAMESPACE__ . '\\POST_TYPE', \RRZE\Downloads\Config::get('attachment_post_type'));
define(__NAMESPACE__ . '\\TAXONOMY', \RRZE\Downloads\Config::get('attachment_document_taxonomy'));

function set(): void {
    $labels = array(
        'name' => __('Documents', 'rrze-downloads'),
        'singular_name' => __('Document', 'rrze-downloads'),
        'search_items' => __('Search Documents', 'rrze-downloads'),
        'all_items' => __('All Documents', 'rrze-downloads'),
        'parent_item' => __('Parent Document', 'rrze-downloads'),
        'parent_item_colon' => __('Parent Document:', 'rrze-downloads'),
        'edit_item' => __('Edit Document', 'rrze-downloads'),
        'update_item' => __('Update Document', 'rrze-downloads'),
        'add_new_item' => __('Add New Document', 'rrze-downloads'),
        'new_item_name' => __('Name', 'rrze-downloads'),
        'menu_name' => __('Documents', 'rrze-downloads'),
    );

    register_taxonomy(TAXONOMY, POST_TYPE, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'query_var' => true,
        'rewrite' => array('slug' => TAXONOMY),
        'update_count_callback' => '_update_generic_term_count',
        'capabilities' => array(
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_attachment',
        ),
    ));
}

function register(): void {
    register_taxonomy_for_object_type(TAXONOMY, POST_TYPE);

    add_action('restrict_manage_posts', __NAMESPACE__ . '\\filterList');
    add_action('pre_get_posts', __NAMESPACE__ . '\\filtering');
}

function filterList(): void {
    global $wp_query;

    $screen = get_current_screen();
    if ($screen->parent_file !== 'upload.php' || !get_terms(TAXONOMY)) {
        return;
    }

    wp_dropdown_categories(array(
        'show_option_all' => __('All Documents', 'rrze-downloads'),
        'taxonomy' => TAXONOMY,
        'name' => TAXONOMY,
        'orderby' => 'name',
        'selected' => isset($wp_query->query[TAXONOMY]) ? $wp_query->query[TAXONOMY] : '',
        'hierarchical' => true,
        'depth' => 6,
        'show_count' => false,
        'hide_empty' => true,
    ));
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
        'include_children' => true,
    );

    $query->set('tax_query', $taxQuery);
    $query->set(TAXONOMY, '');
}
