<?php


    function set_attachment_category() {
        $labels = array(
            'name' => __('Medienkategorien', 'rrze-downloads'),
            'singular_name' => __('Kategorie', 'rrze-downloads'),
            'search_items' => __('Kategorien suchen', 'rrze-downloads'),
            'all_items' => __('Alle Kategorien', 'rrze-downloads'),
            'parent_item' => __('Übergeordnet', 'rrze-downloads'),
            'parent_item_colon' => __('Übergeordnet:', 'rrze-downloads'),
            'edit_item' => __('Kategorie bearbeiten', 'rrze-downloads'),
            'update_item' => __('Kategorie aktualisieren', 'rrze-downloads'),
            'add_new_item' => __('Neue Kategorie hinzufügen', 'rrze-downloads'),
            'new_item_name' => __('Name', 'rrze-downloads'),
            'menu_name' => __('Medienkategorien', 'rrze-downloads'),
        );
	$args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'query_var' => true,
            'update_count_callback' => '_update_generic_term_count',
            'rewrite' =>  true,
	    
        );
	register_taxonomy('attachment_category','attachment',$args);
	
    }
    add_action('init','set_attachment_category');
    

    function attachment_category_filter_list() {
        global $wp_query;
        $screen = get_current_screen();
        if ($screen->parent_base == 'upload' && get_terms('attachment_category')) {
            wp_dropdown_categories(array(
                'show_option_all' => __('Alle Medien', 'rrze-downloads'),
                'taxonomy' => 'attachment_category',
                'name' => 'attachment_category',
                'orderby' => 'name',
                'selected' => ( isset($wp_query->query['attachment_category']) ? $wp_query->query['attachment_category'] : '' ),
                'hierarchical' => true,
                'depth' => 6,
                'show_count' => false,
                'hide_empty' => true,
            ));
        }
    }

    function attachment_category_filtering($query) {
        $qv = &$query->query_vars;
        if (!empty($qv['attachment_category']) && is_numeric($qv['attachment_category'])) {
            $term = get_term_by('id', $qv['attachment_category'], 'attachment_category');
            $qv['attachment_category'] = $term->slug;
        }
    }
    function register_attachment_category() {
       register_taxonomy_for_object_type('attachment_category', 'attachment');
        add_action('restrict_manage_posts', 'attachment_category_filter_list');
        add_filter('parse_query', 'attachment_category_filtering');
    }
    
    register_attachment_category();
