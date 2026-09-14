<?php

namespace RRZE\Downloads\Taxonomies;

class Media {
    
    private $allowed_taxonomies = array();
    
    public function __construct(array $allowedTaxonomies) {
        $this->allowed_taxonomies = $allowedTaxonomies;

        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_filter('attachment_fields_to_edit', array($this, 'attachment_fields_to_edit'), 10, 2);
        add_action('wp_ajax_save-media-terms', array($this, 'save_media_terms'), 0, 1);
        add_action('wp_ajax_add-media-term', array($this, 'add_media_term'), 0, 1);
        add_filter('user_has_cap', array($this, 'add_user_caps'));
    }
    
    public function admin_enqueue_scripts($hookSuffix = '') {
        if (!in_array($hookSuffix, array('upload.php', 'post.php', 'post-new.php'), true)) {
            return;
        }

        wp_enqueue_media();

        wp_enqueue_script(
            'rrze-downloads-admin',
            plugins_url('../../build/js/rrze-downloads-admin.js', __FILE__),
            array('jquery', 'media-views', 'underscore'),
            \RRZE\Downloads\Config::get('version'),
            true
        );
        wp_localize_script(
            'rrze-downloads-admin',
            'rrzeDownloadsMedia',
            [
                'nonce' => wp_create_nonce('rrze-downloads-media-terms'),
            ]
        );
        wp_enqueue_style(
            'rrze-downloads-admin',
            plugins_url('../../build/css/rrze-downloads-admin.css', __FILE__),
            array(),
            \RRZE\Downloads\Config::get('version')
        );
    }
    
    public function add_user_caps($user_caps) {
        $user = wp_get_current_user();

        if (in_array('upload_files', (array) $user->allcaps)) {
            $user_caps['edit_attachment'] = TRUE;
        }

        return $user_caps;        
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
        check_ajax_referer('rrze-downloads-media-terms', 'nonce');

        $post_id = isset($_POST['attachment_id']) ? absint($_POST['attachment_id']) : 0;
        $taxonomy = isset($_POST['taxonomy']) ? sanitize_key(wp_unslash($_POST['taxonomy'])) : '';
        $termIds = isset($_POST['term_ids']) ? (array) wp_unslash($_POST['term_ids']) : [];

        if (!$post_id || !current_user_can('edit_post', $post_id) || !$this->isAllowedTaxonomy($taxonomy)) {
            wp_send_json_error(['message' => __('You are not allowed to edit these media terms.', 'rrze-downloads')], 403);
        }

        $termIds = array_map('absint', $termIds);

        $response = wp_set_post_terms($post_id, $termIds, $taxonomy);

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => $response->get_error_message()], 400);
        }

        wp_update_term_count_now($termIds, $taxonomy);
        wp_send_json_success();
    }
    
    public function add_media_term() {
        check_ajax_referer('rrze-downloads-media-terms', 'nonce');

        $response = array();
        $attachmentId = isset($_POST['attachment_id']) ? absint($_POST['attachment_id']) : 0;
        $taxonomyName = isset($_POST['taxonomy']) ? sanitize_key(wp_unslash($_POST['taxonomy'])) : '';
        $taxonomy = get_taxonomy($taxonomyName);
        $parent = isset($_POST['parent']) ? absint($_POST['parent']) : 0;
        $termName = isset($_POST['term']) ? sanitize_text_field(wp_unslash($_POST['term'])) : '';

        if (!$attachmentId || !$taxonomy || !$termName || !$this->isAllowedTaxonomy($taxonomyName)) {
            wp_send_json_error(['message' => __('Invalid media term request.', 'rrze-downloads')], 400);
        }

        if (!current_user_can('edit_post', $attachmentId) || !current_user_can($taxonomy->cap->manage_terms)) {
            wp_send_json_error(['message' => __('You are not allowed to add media terms.', 'rrze-downloads')], 403);
        }

        // Check if term already exists.
        $term = get_term_by('name', $termName, $taxonomy->name);

        // Add a new term if necessary.
        if (!$term) {
            $term = wp_insert_term($termName, $taxonomy->name, array('parent' => $parent));

            if (is_wp_error($term)) {
                wp_send_json_error(['message' => $term->get_error_message()], 400);
            }

            $term = get_term_by('id', $term['term_id'], $taxonomy->name);
        }

        // Connect attachment with term
        wp_set_object_terms($attachmentId, $term->term_id, $taxonomy->name, true);

        $attachment_terms = wp_get_object_terms($attachmentId, $taxonomy->name, array(
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

        wp_send_json_success($response);
    }

    private function isAllowedTaxonomy(string $taxonomy): bool {
        return in_array($taxonomy, $this->allowed_taxonomies, true)
            && \RRZE\Downloads\Taxonomies::isManaged($taxonomy);
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

            <div class="media-terms" data-id="<?php echo esc_attr($post_id); ?>" data-taxonomy="<?php echo esc_attr($taxonomy->name); ?>">

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
            <a href="#" class="toggle-add-media-term"><?php echo esc_html($taxonomy->labels->add_new_item); ?></a>
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
                <button class="button save-media-term" data-taxonomy="<?php echo esc_attr($taxonomy->name); ?>" data-id="<?php echo esc_attr($post_id); ?>">
                    <?php echo esc_html($taxonomy->labels->add_new_item); ?>
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
