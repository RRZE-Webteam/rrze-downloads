<?php

function rrze_downloads($atts, $content = null) {
    $args = shortcode_atts(array(
        "category" => '',
        "cat" => '',
        "tags" => '',
        "format" => 'liste',
        "htmlpre" => '',
        "htmlpost" => '',
        "htmlitempre" => '',
        "htmlitempost" => '',
        "search_application" => false,
        "search_image" => false,
        "search_video" => false,
        "search_audio" => false,
        "search_text" => false,
        "showsize" => true,
        "showcreated" => false,
        "showexcerpt" => false,
        "showcontent" => false,
        "errormsg" => '',
        "orderby" => 'title',
        "sort" => 'asc'
            ), $atts, 'shortcodedownload');
    $category = esc_attr($args['category']);
    $cat = esc_attr($args['cat']);
    $tags = esc_attr($args['tags']);
    $format = esc_attr($args['format']);
    $htmlpre = esc_attr($args['htmlpre']);
    $htmlpost = esc_attr($args['htmlpost']);
    $htmlitempre = esc_attr($args['htmlitempre']);
    $htmlitempost = esc_attr($args['htmlitempost']);
    $errormsg = esc_attr($args['errormsg']);
    $orderby = esc_attr($args['orderby']);
    $sort = esc_attr($args['sort']);

    $search_application = filter_var($args['search_application'], FILTER_VALIDATE_BOOLEAN);
    $search_image = filter_var($args['search_image'], FILTER_VALIDATE_BOOLEAN);
    $search_video = filter_var($args['search_video'], FILTER_VALIDATE_BOOLEAN);
    $search_audio = filter_var($args['search_audio'], FILTER_VALIDATE_BOOLEAN);
    $search_text = filter_var($args['search_text'], FILTER_VALIDATE_BOOLEAN);
    $showsize = filter_var($args['showsize'], FILTER_VALIDATE_BOOLEAN);
    $showcreated = filter_var($args['showcreated'], FILTER_VALIDATE_BOOLEAN);
    $showexcerpt = filter_var($args['showexcerpt'], FILTER_VALIDATE_BOOLEAN);
    $showcontent = filter_var($args['showcontent'], FILTER_VALIDATE_BOOLEAN);

    $orderby = !empty($orderby) && in_array(strtolower($orderby), array('title', 'date')) ? strtolower($orderby) : 'title';
    $sort = !empty($sort) && in_array(strtoupper($sort), array('ASC', 'DESC')) ? strtoupper($sort) : 'ASC';

    if (empty($category)) {
        $catname = $cat;
    } else {
        $catname = $category;
    }

    $category = get_term_by('slug', $catname, 'attachment_category');

    $return = '';

    $args = array('post_type' => 'attachment',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'orderby' => $orderby,
        'order' => $sort,
        'tax_query' => array(
        ),
        'suppress_filters' => true);
    if ($category) {
        $catquery = array(
            'taxonomy' => 'attachment_category',
            'field' => 'id', // can be slug or id - a CPT-onomy term's ID is the same as its post ID
            'terms' => $category->term_id,
            'include_children' => false
        );
        $args['tax_query'][] = $catquery;
    }
    if ($tags) {
        $tagquery = array(
            'taxonomy' => 'attachment_tag',
            'field' => 'slug',
            'terms' => explode(',', $tags),
        );
        $args['tax_query'][] = $tagquery;
    }



    $mimetype = array();
    if ($search_application == true) {
        $mimetype[] = 'application';
    }
    if ($search_video == true) {
        $mimetype[] = 'video';
    }
    if ($search_image == true) {
        $mimetype[] = 'image';
    }
    if ($search_audio == true) {
        $mimetype[] = 'audio';
    }
    if ($search_text == true) {
        $mimetype[] = 'text';
    }
    if (!empty($mimetype)) {
        $args['post_mime_type'] = $mimetype;
    } else {
        $args['post_mime_type'] = "application";
    }


    $files = get_posts($args);

    if ($files) {
        $prehtml = '';
        $posthtml = '';

        if ($format == 'table') {
            $prehtml = '<table class="files">';
            $posthtml = "</table>";
        } elseif ($format == 'liste') {
            $prehtml = '<ul class="files">';
            $posthtml = "</ul>";
        } else {
            $prehtml = '<' . $htmlpre . '>';
            $posthtml = '</' . $htmlpost . '>';
        }

        $contentlist = '';

        foreach ($files as $file) {


            $size = size_format(filesize(get_attached_file($file->ID)), 2);
            $excerpt = wpautop($file->post_excerpt);
            $desc = wpautop($file->post_content);
            $created = date_i18n(get_option('date_format'), strtotime($file->post_date));
            $parsed = parse_url(wp_get_attachment_url($file->ID) );
            $url = dirname($parsed['path']) . '/' . rawurlencode(basename($parsed[ 'path' ]));
            $title = $file->post_title;

            $addinfo = '';
            if ($showsize || $showcreated) {
                if ($showcreated) {
                    $addinfo .= $created;
                }
                if ($showsize == true) {
                    if ($addinfo)
                        $addinfo .= ", ";
                    $addinfo .= $size;
                }
                if ($addinfo) {
                    $addinfo = ' (' . $addinfo . ')';
                }
            }



            if ($format == 'table') {
                $contentlist .= '<tr><th>' . $file->post_title . '</th><td><a href="' . $url . '">' . $file->post_title . '</a>';
                $contentlist .= $addinfo;

                if ($showexcerpt == true) {
                    $contentlist .= $excerpt;
                }
                if ($showcontent == true) {
                    $contentlist .= $desc;
                }
                $contentlist .= '</td></tr>';
            } elseif ($format == 'liste') {
                $contentlist .= '<li>';
                $contentlist .= '<a href="' . $url . '">' . $file->post_title . '</a>';
                $contentlist .= $addinfo;
                if ($showexcerpt) {
                    $contentlist .= $excerpt;
                }
                if ($showcontent) {
                    $contentlist .= $desc;
                }
                $contentlist .= '</li>';
            } else {
                $contentlist .= '<' . $htmlitempre . '>';
                $contentlist .= '<a href="' . $url . '">' . $file->post_title . '</a>';
                $contentlist .= $addinfo;
                if ($showexcerpt) {
                    $contentlist .= $excerpt;
                }
                if ($showcontent) {
                    $contentlist .= $desc;
                }
                $contentlist .= '</' . $htmlitempost . '>';
            }
        }

        $return .= $prehtml;
        $return .= $contentlist;
        $return .= $posthtml;
    } else {
        if ($errormsg) {
            $return .= '<p class="attention">' . $errormsg . '</p>';
        } else {
            $return .= '<p class="info">' . __('Dowloads: Es konnten keine Dateien gefunden werden.', 'rrze-downloads') . '</p>';
        }
    }


    return $return;
}
