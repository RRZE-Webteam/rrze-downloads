<?php

function set_media_category() {
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
        'update_count_callback' => 'media_category_update_count_callback',
        'rewrite' => true,
    );

    $taxonomy = 'attachment_category';
    
    register_taxonomy($taxonomy, 'attachment', $args);  
}

add_action('init', 'set_media_category');

function media_category_update_count_callback($terms = array(), $taxonomy = 'attachment_category') {
    global $wpdb;

    $taxonomy = 'attachment_category';

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
    add_action('add_attachment', 'media_category_set_attachment_category');
    add_action('edit_attachment', 'media_category_set_attachment_category');
    add_action('restrict_manage_posts', 'media_category_filter');
    add_action('wp_ajax_query-attachments', 'media_category_ajax_query_attachments', 0);
    add_action('admin_enqueue_scripts', 'media_category_enqueue_media_action');
    add_action('wp_ajax_save-attachment-compat', 'media_category_save_attachment_compat', 0);
    add_filter('attachment_fields_to_edit', 'media_category_attachment_fields_to_edit', 10, 2);
}

function media_category_set_attachment_category($post_ID) {

    $taxonomy = 'attachment_category';

    if (wp_get_object_terms($post_ID, $taxonomy)) {
        return;
    }

    $post_category = array(get_option('default_category'));

    if ($post_category) {
        wp_set_post_categories($post_ID, $post_category);
    }
}

function media_category_filter() {
    global $pagenow, $wp_query;
    
    if ('upload.php' == $pagenow) {
        $taxonomy = 'attachment_category';

        $dropdown_options = array(
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'show_option_all' => __('Alle Kategorien', 'rrze-downloads'),
            'hide_empty' => false,
            'hierarchical' => true,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[$taxonomy]) ? $wp_query->query[$taxonomy] : '',
            'show_count' => true,
            'walker' => new media_category_walker(),
            'value' => 'slug'
        );

        wp_dropdown_categories($dropdown_options);
    }
}

function media_category_ajax_query_attachments() {

    if (!current_user_can('upload_files')) {
        wp_send_json_error();
    }

    $taxonomies = get_object_taxonomies('attachment', 'names');

    $query = isset($_REQUEST['query']) ? (array) $_REQUEST['query'] : array();

    $defaults = array(
        's', 'order', 'orderby', 'posts_per_page', 'paged', 'post_mime_type',
        'post_parent', 'post__in', 'post__not_in'
    );

    $query = array_intersect_key($query, array_flip(array_merge($defaults, $taxonomies)));

    $query['post_type'] = 'attachment';
    $query['post_status'] = 'inherit';

    if (current_user_can(get_post_type_object('attachment')->cap->read_private_posts)) {
        $query['post_status'] .= ',private';
    }

    $query['tax_query'] = array('relation' => 'AND');

    foreach ($taxonomies as $taxonomy) {
        if (isset($query[$taxonomy]) && is_numeric($query[$taxonomy])) {
            array_push($query['tax_query'], array(
                'taxonomy' => $taxonomy,
                'field' => 'id',
                'terms' => $query[$taxonomy]
            ));
        }
        unset($query[$taxonomy]);
    }

    $query = apply_filters('ajax_query_attachments_args', $query);
    $query = new WP_Query($query);

    $posts = array_map('wp_prepare_attachment_for_js', $query->posts);
    $posts = array_filter($posts);

    wp_send_json_success($posts);
}

function media_category_enqueue_media_action() {
    global $pagenow, $wp_query;
    
    if (wp_script_is('media-editor') && 'upload.php' == $pagenow) {

        $taxonomy = 'attachment_category';

        $dropdown_options = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'hierarchical' => true,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[$taxonomy]) ? $wp_query->query[$taxonomy] : '',
            'show_count' => true,
            'walker' => new media_category_grid_view_walker(),
            'value' => 'id',
            'echo' => false
        );

        $attachment_terms = wp_dropdown_categories($dropdown_options);
        $attachment_terms = preg_replace(array("/<select([^>]*)>/", "/<\/select>/"), "", $attachment_terms);

        echo '<script type="text/javascript">';
        echo '/* <![CDATA[ */';
        echo 'var attachment_categories = {"' . $taxonomy . '":{"list_title":"' . html_entity_decode(__('Alle Kategorien', 'rrze-downloads'), ENT_QUOTES, 'UTF-8') . '","term_list":[' . substr($attachment_terms, 2) . ']}};';
        echo '/* ]]> */';
        echo '</script>';

        wp_enqueue_script('rrze-downloads-media-categories', plugins_url('js/media-categories.js', dirname(__FILE__)), array('media-views'), '1.1.0', true);
    }
    
    wp_enqueue_style('rrze-downloads-media-categories', plugins_url('css/media-categories.css', dirname(__FILE__)), array(), '1.1.0');
}

function media_category_save_attachment_compat() {

    if (!isset($_REQUEST['id'])) {
        wp_send_json_error();
    }

    if (!$id = absint($_REQUEST['id'])) {
        wp_send_json_error();
    }

    if (empty($_REQUEST['attachments']) || empty($_REQUEST['attachments'][$id])) {
        wp_send_json_error();
    }
    
    $attachment_data = $_REQUEST['attachments'][$id];

    check_ajax_referer('update-post_' . $id, 'nonce');

    if (!current_user_can('edit_post', $id)) {
        wp_send_json_error();
    }

    $post = get_post($id, ARRAY_A);

    if ('attachment' != $post['post_type']) {
        wp_send_json_error();
    }

    $post = apply_filters('attachment_fields_to_save', $post, $attachment_data);

    if (isset($post['errors'])) {
        unset($post['errors']);
    }

    wp_update_post($post);

    foreach (get_attachment_taxonomies($post) as $taxonomy) {
        if (isset($attachment_data[$taxonomy])) {
            wp_set_object_terms($id, array_map('trim', preg_split('/,+/', $attachment_data[$taxonomy])), $taxonomy, false);
        } else if (isset($_REQUEST['tax_input']) && isset($_REQUEST['tax_input'][$taxonomy])) {
            wp_set_object_terms($id, $_REQUEST['tax_input'][$taxonomy], $taxonomy, false);
        } else {
            wp_set_object_terms($id, '', $taxonomy, false);
        }
    }

    if (!$attachment = wp_prepare_attachment_for_js($id)) {
        wp_send_json_error();
    }

    wp_send_json_success($attachment);
}

function media_category_attachment_fields_to_edit($form_fields, $post) {

    foreach (get_attachment_taxonomies($post->ID) as $taxonomy) {
        $terms = get_object_term_cache($post->ID, $taxonomy);

        $t = (array) get_taxonomy($taxonomy);
        if (!$t['public'] || !$t['show_ui']) {
            continue;
        }
        if (empty($t['label'])) {
            $t['label'] = $taxonomy;
        }
        if (empty($t['args'])) {
            $t['args'] = array();
        }

        if (false === $terms) {
            $terms = wp_get_object_terms($post->ID, $taxonomy, $t['args']);
        }

        $values = array();

        foreach ($terms as $term) {
            $values[] = $term->slug;
        }

        $t['value'] = join(', ', $values);
        $t['show_in_edit'] = false;

        if ($t['hierarchical']) {
            ob_start();

            wp_terms_checklist($post->ID, array('taxonomy' => $taxonomy, 'checked_ontop' => false, 'walker' => new media_category_terms_checklist_walker()));

            if (ob_get_contents() != false) {
                $html = '<ul class="term-list">' . ob_get_contents() . '</ul>';
            } else {
                $html = '<ul class="term-list"><li>No ' . $t['label'] . '</li></ul>';
            }

            ob_end_clean();

            $t['input'] = 'html';
            $t['html'] = $html;
        }

        $form_fields[$taxonomy] = $t;
    }

    return $form_fields;
}

class media_category_walker extends Walker_CategoryDropdown {

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);
        $cat_name = apply_filters('list_cats', $category->name, $category);

        if (!isset($args['value'])) {
            $args['value'] = ( $category->taxonomy != 'attachment_category' ? 'slug' : 'id' );
        }

        $value = ( $args['value'] == 'slug' ? $category->slug : $category->term_id );
        if (0 == $args['selected'] && isset($_GET['category_media']) && '' != $_GET['category_media']) {
            $args['selected'] = $_GET['category_media'];
        }

        $output .= '<option class="level-' . $depth . '" value="' . $value . '"';
        if ($value === (string) $args['selected']) {
            $output .= ' selected="selected"';
        }
        
        $output .= '>';
        $output .= $pad . $cat_name;
        if ($args['show_count']) {
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        }

        $output .= "</option>\n";
    }

}

class media_category_grid_view_walker extends Walker_CategoryDropdown {

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

class media_category_terms_checklist_walker extends Walker {

    var $tree_type = 'attachment_category';
    var $db_fields = array(
        'parent' => 'parent',
        'id' => 'term_id'
    );

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        extract($args);

        $taxonomy = 'attachment_category';

        $name = 'tax_input[' . $taxonomy . ']';

        $class = in_array($category->term_id, $popular_cats) ? ' class="popular-category"' : '';
        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->slug . '" type="checkbox" name="' . $name . '[' . $category->slug . ']" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
    }

    function end_el(&$output, $category, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }

}
