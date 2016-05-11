<?php

function set_attachment_tag() {
    $labels = array(
        'name' => __('Schlagworte', 'rrze-downloads'),
        'singular_name' => __('Schlagwort', 'rrze-downloads'),
        'search_items' => __('Schlagwörter suchen', 'rrze-downloads'),
        'popular_items' => __('Beliebte Schlagwörter', 'rrze-downloads'),
        'all_items' => __('Alle Schlagwörtern', 'rrze-downloads'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Schlagwort bearbeiten', 'rrze-downloads'),
        'update_item' => __('Schlagwort aktualisieren', 'rrze-downloads'),
        'add_new_item' => __('Neues Schlagwort erstellen', 'rrze-downloads'),
        'new_item_name' => __('Name', 'rrze-downloads'),
        'separate_items_with_commas' => __('Trenne Schlagwörter durch Kommas', 'rrze-downloads'),
        'add_or_remove_items' => __('Hinzu', 'rrze-downloads'),
        'choose_from_most_used' => __('Wähle aus den häufig genutzten Schlagwörtern', 'rrze-downloads'),
        'menu_name' => __('Schlagworte', 'rrze-downloads'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => false,
        'query_var' => true,
        'update_count_callback' => 'media_tag_update_count_callback',
        'rewrite' => true,
    );
    
    $taxonomy = 'attachment_tag';
    
    register_taxonomy($taxonomy, 'attachment', $args);     
}

add_action('init', 'set_attachment_tag');

function media_tag_update_count_callback($terms = array(), $taxonomy = 'attachment_tag') {
    global $wpdb;

    $taxonomy = 'attachment_tag';

    $query = "SELECT term_taxonomy_id, MAX(total) AS total FROM ((
	SELECT tt.term_taxonomy_id, COUNT(*) AS total FROM $wpdb->term_relationships tr, $wpdb->term_taxonomy tt WHERE tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = %s GROUP BY tt.term_taxonomy_id
	) UNION ALL (
	SELECT term_taxonomy_id, 0 AS total FROM $wpdb->term_taxonomy WHERE taxonomy = %s
	)) AS unioncount GROUP BY term_taxonomy_id";
    
    $rs_count = $wpdb->get_results($wpdb->prepare($query, $taxonomy, $taxonomy));

    foreach ($rs_count as $row_count) {
        $wpdb->update($wpdb->term_taxonomy, array('count' => $row_count->total), array('term_taxonomy_id' => $row_count->term_taxonomy_id));
    }
}

if (is_admin()) {
    add_action('restrict_manage_posts', 'media_tag_filter');
    add_filter('parse_query', 'media_tag_filtering');
    add_action('admin_enqueue_scripts', 'media_tag_enqueue_media_action');
}

function media_tag_filter() {
    global $pagenow, $wp_query;
    
    if ('upload.php' == $pagenow) {
        $taxonomy = 'attachment_tag';
        
        wp_dropdown_categories(array(
            'show_option_all' => __('Alle Schlagworte', 'rrze-downloads'),
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[$taxonomy]) ? $wp_query->query[$taxonomy] : '',
            'hierarchical' => false,
            'show_count' => true,
            'hide_empty' => true,
        ));
    }
}

function media_tag_filtering($query) {
    $taxonomy = 'attachment_tag';
    $qv = &$query->query_vars;
    
    if (!empty($qv[$taxonomy]) && is_numeric($qv[$taxonomy])) {
        $term = get_term_by('id', $qv[$taxonomy], $taxonomy);
        $qv[$taxonomy] = $term->slug;
    }
}

function media_tag_enqueue_media_action() {
    global $pagenow, $wp_query;
    
    if (wp_script_is('media-editor') && 'upload.php' == $pagenow) {

        $taxonomy = 'attachment_tag';

        $dropdown_options = array(
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'hide_empty' => true,
            'hierarchical' => false,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[$taxonomy]) ? $wp_query->query[$taxonomy] : '',
            'show_count' => true,
            'walker' => new media_tag_grid_view_walker(),
            'value' => 'id',
            'echo' => false
        );

        $attachment_terms = wp_dropdown_categories($dropdown_options);
        $attachment_terms = preg_replace(array("/<select([^>]*)>/", "/<\/select>/"), "", $attachment_terms);

        echo '<script type="text/javascript">';
        echo '/* <![CDATA[ */';
        echo 'var attachment_tags = {"' . $taxonomy . '":{"list_title":"' . html_entity_decode(__('Alle Schlagworte', 'rrze-downloads'), ENT_QUOTES, 'UTF-8') . '","term_list":[' . substr($attachment_terms, 2) . ']}};';
        echo '/* ]]> */';
        echo '</script>';

        wp_enqueue_script('rrze-downloads-media-tags', plugins_url('js/media-tags.js', dirname(__FILE__)), array('media-views'), '1.1.0', true);
    }
    
}

class media_tag_grid_view_walker extends Walker_CategoryDropdown {

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $cat_name = apply_filters('list_cats', $category->name, $category);

        $output .= ',{"term_id":"' . $category->term_id . '",';

        $output .= '"term_name":"' . esc_attr($cat_name);
        if ($args['show_count']) {
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        }
        $output .= '"}';
    }

}
