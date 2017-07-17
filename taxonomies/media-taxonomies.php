<?php

namespace RRZE\Downloads\Taxonomies;

class Media {
    
    private $allowed_taxonomies = array('attachment_category', 'attachment_tag');
    
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_filter('attachment_fields_to_edit', array($this, 'attachment_fields_to_edit'), 10, 2);
        add_action('wp_ajax_save-media-terms', array($this, 'save_media_terms'), 0, 1);
        add_action('wp_ajax_add-media-term', array($this, 'add_media_term'), 0, 1);
    }
    
    public function admin_enqueue_scripts() {
        if (!wp_script_is('media-views')) {
            return;
        }
        
        wp_enqueue_script('rrze-downloads-media-taxonomies', plugins_url('js/media-taxonomies.js', __FILE__), array('jquery'), false, true);
        wp_enqueue_style('rrze-downloads-media-taxonomies', plugins_url('css/media-taxonomies.css', __FILE__));
        wp_enqueue_script('rrze-downloads-media-toolbar', plugins_url('js/media-toolbar.js', __FILE__), array('jquery'), false, true);
        wp_enqueue_style('rrze-downloads-media-toolbar', plugins_url('css/media-toolbar.css', __FILE__));
    }
    
    public function attachment_fields_to_edit($fields, $post) {

        $screen = get_current_screen();

        if (isset($screen->id) && 'attachment' == $screen->id) {
            return $fields;
        }

        $taxonomies = apply_filters('rrze-downloads-media-taxonomies', get_object_taxonomies('attachment', 'objects'));

        if (!$taxonomies) {
            return $fields;
        }

        foreach ($taxonomies as $taxonomyname => $taxonomy) {
            if (!in_array($taxonomyname, $this->allowed_taxonomies)) {
                continue;
            }

            $fields[$taxonomyname] = array(
                'label' => $taxonomy->labels->name,
                'input' => 'html',
                'html' => $this->terms_checkboxes($taxonomy, $post->ID),
                'show_in_edit' => true,
            );

        }

        return $fields;
    }
    
    public function save_media_terms() {

        $post_id = intval($_REQUEST['attachment_id']);

        if (!current_user_can('edit_post', $post_id)) {
            die();
        }

        $term_ids = array_map('intval', $_REQUEST['term_ids']);

        $response = wp_set_post_terms($post_id, $term_ids, sanitize_text_field($_REQUEST['taxonomy']));
        wp_update_term_count_now($term_ids, sanitize_text_field($_REQUEST['taxonomy']));
    }
    
    public function add_media_term() {
        $response = array();
        $attachment_id = intval($_REQUEST['attachment_id']);
        $taxonomy = get_taxonomy(sanitize_text_field($_REQUEST['taxonomy']));
        $parent = intval($_REQUEST['parent']) > 0 ? intval($_REQUEST['parent']) : 0;

        // Check if term already exists
        $term = get_term_by('name', sanitize_text_field($_REQUEST['term']), $taxonomy->name);

        // No, so lets add it
        if (!$term) {
            $term = wp_insert_term(sanitize_text_field($_REQUEST['term']), $taxonomy->name, array('parent' => $parent));
            $term = get_term_by('id', $term['term_id'], $taxonomy->name);
        }

        // Connect attachment with term
        wp_set_object_terms($attachment_id, $term->term_id, $taxonomy->name, TRUE);

        $attachment_terms = wp_get_object_terms($attachment_id, $taxonomy->name, array(
            'fields' => 'ids'
        ));

        ob_start();
        wp_terms_checklist(0, array(
            'selected_cats' => $attachment_terms,
            'taxonomy' => $taxonomy->name,
            'checked_ontop' => FALSE
        ));
        $checklist = ob_get_contents();
        ob_end_clean();

        $response['checkboxes'] = $checklist;
        $response['selectbox'] = wp_dropdown_categories(array(
            'taxonomy' => $taxonomy->name,
            'class' => 'parent-' . $taxonomy->name,
            'id' => 'parent-' . $taxonomy->name,
            'name' => 'parent-' . $taxonomy->name,
            'show_option_none' => '- ' . $taxonomy->labels->parent_item . ' -',
            'hide_empty' => FALSE,
            'echo' => FALSE,
        ));

        die(json_encode($response));
    }
    
    private function terms_checkboxes($taxonomy, $post_id) {

        if (!is_object($taxonomy)) {
            $taxonomy = get_taxonomy($taxonomy);
        }

        $terms = get_terms($taxonomy->name, array(
            'hide_empty' => FALSE,
        ));

        $attachment_terms = wp_get_object_terms($post_id, $taxonomy->name, array(
            'fields' => 'ids'
        ));

        ob_start();
        ?>
        <div class="media-term-section">

            <div class="media-terms" data-id="<?php echo $post_id ?>" data-taxonomy="<?php echo $taxonomy->name ?>">

                <ul>
        <?php
        wp_terms_checklist(0, array(
            'selected_cats' => $attachment_terms,
            'taxonomy' => $taxonomy->name,
            'checked_ontop' => FALSE
        ));
        ?>
                </ul>

            </div>
            <?php if (current_user_can('manage_categories')): ?>
            <a href="#" class="toggle-add-media-term"><?php echo $taxonomy->labels->add_new_item ?></a>
            <?php endif; ?>

            <div class="add-new-term">

                <input type="text" value="">

        <?php
        if ($taxonomy->hierarchical) :
            wp_dropdown_categories(array(
                'taxonomy' => $taxonomy->name,
                'class' => 'parent-' . $taxonomy->name,
                'id' => 'parent-' . $taxonomy->name,
                'name' => 'parent-' . $taxonomy->name,
                'show_option_none' => '- ' . $taxonomy->labels->parent_item . ' -',
                'hide_empty' => FALSE,
            ));
        endif;
        ?>
        <?php if (current_user_can('manage_categories')): ?> 
                <button class="button save-media-term" data-taxonomy="<?php echo $taxonomy->name ?>" data-id="<?php echo $post_id ?>">
                    <?php echo $taxonomy->labels->add_new_item ?>
                </button>
        <?php endif; ?>
            </div>

        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return apply_filters('rrze-downloads-media-checkboxes', $output, $taxonomy, $terms);
    }
    
}