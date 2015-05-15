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

        register_taxonomy('attachment_tag', 'attachment', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'update_count_callback' => '_update_generic_term_count',
            'rewrite' => array('slug' => 'attachment_tag'),
        ));
 }
 
add_action('init','set_attachment_tag');
	

    
function attachment_tag_filter_list() {
        global $wp_query;
        $screen = get_current_screen();
        if ($screen->parent_base == 'upload' && get_terms('attachment_tag')) {
            wp_dropdown_categories(array(
                'show_option_all' => __('Alle Schlagworte', 'rrze-downloads'),
                'taxonomy' => 'attachment_tag',
                'name' => 'attachment_tag',
                'orderby' => 'name',
                'selected' => ( isset($wp_query->query['attachment_tag']) ? $wp_query->query['attachment_tag'] : '' ),
                'hierarchical' => false,
                'show_count' => false,
                'hide_empty' => true,
            ));
        }
    }

function attachment_tag_filtering($query) {
        $qv = &$query->query_vars;
        if (!empty($qv['attachment_tag']) && is_numeric($qv['attachment_tag'])) {
            $term = get_term_by('id', $qv['attachment_tag'], 'attachment_tag');
            $qv['attachment_tag'] = $term->slug;
        }
    }    
function register_attachment_tag() {
        register_taxonomy_for_object_type('attachment_tag', 'attachment');
        add_action('restrict_manage_posts', 'attachment_tag_filter_list');
        add_filter('parse_query',  'attachment_tag_filtering');
    }
    
register_attachment_tag();    
