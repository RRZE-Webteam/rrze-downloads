<?php

namespace RRZE\Downloads\Taxonomies\AttachmentTag;

const POST_TYPE = 'attachment';
const TAXONOMY = 'attachment_tag';

function set() {
    $labels = array(
        'name' => __('Schlagwörter', 'rrze-downloads'),
        'singular_name' => __('Schlagwort', 'rrze-downloads'),
        'search_items' => __('Schlagwörter suchen', 'rrze-downloads'),
        'popular_items' => __('Beliebte Schlagwörter', 'rrze-downloads'),
        'all_items' => __('Alle Schlagwörter', 'rrze-downloads'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Schlagwort bearbeiten', 'rrze-downloads'),
        'update_item' => __('Schlagwort aktualisieren', 'rrze-downloads'),
        'add_new_item' => __('Neues Schlagwort erstellen', 'rrze-downloads'),
        'new_item_name' => __('Name', 'rrze-downloads'),
        'separate_items_with_commas' => __('Trenne Schlagwörter durch Kommas', 'rrze-downloads'),
        'add_or_remove_items' => __('Hinzu', 'rrze-downloads'),
        'choose_from_most_used' => __('Wähle aus den häufig genutzten Schlagwörtern', 'rrze-downloads'),
        'menu_name' => __('Schlagwörter', 'rrze-downloads')
    );

    register_taxonomy(TAXONOMY, POST_TYPE, array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
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
    
    add_action('admin_enqueue_scripts', 'RRZE\Downloads\Taxonomies\AttachmentTag\media_tag_enqueue_media_action');
}

function filter_list() {
    global $wp_query;
    $screen = get_current_screen();
    if ($screen->parent_file == 'upload.php' && get_terms(TAXONOMY)) {
        wp_dropdown_categories(array(
            'show_option_all' => __('Alle Schlagwörter', 'rrze-downloads'),
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

function media_tag_enqueue_media_action() {
    global $pagenow, $wp_query;
    
    if (wp_script_is('media-editor') && 'upload.php' == $pagenow) {

        $dropdown_options = array(
            'taxonomy' => TAXONOMY,
            'name' => TAXONOMY,
            'hide_empty' => true,
            'hierarchical' => false,
            'orderby' => 'name',
            'selected' => isset($wp_query->query[TAXONOMY]) ? $wp_query->query[TAXONOMY] : '',
            'show_count' => false,
            'walker' => new dropdown(),
            'value' => 'id',
            'echo' => false
        );

        $attachment_terms = wp_dropdown_categories($dropdown_options);
        $attachment_terms = preg_replace(array("/<select([^>]*)>/", "/<\/select>/"), "", $attachment_terms);

        echo '<script type="text/javascript">';
        echo '/* <![CDATA[ */';
        echo 'var attachment_tags = {"' . TAXONOMY . '":{"list_title":"' . html_entity_decode(__('Alle Schlagwörter', 'rrze-downloads'), ENT_QUOTES, 'UTF-8') . '","term_list":[' . substr($attachment_terms, 2) . ']}};';
        echo '/* ]]> */';
        echo '</script>';
    }
    
}

class dropdown extends \Walker_CategoryDropdown {

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
