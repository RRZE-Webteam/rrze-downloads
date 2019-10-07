<?php

function downloadsHandler( $atts ) {
    $atts = shortcode_atts([
        'category' => '',
        "cat" => '',
        "tags" => '',
        "type" => 'category', // category, document
        "format" => 'liste', // table, liste
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
    ], $atts, 'downloads');

    return downloadsOutput( $atts );
}


function downloadsOutput( $args ) {
  $output = '';

  $category = esc_attr($args['category']);
  $cat = esc_attr($args['cat']);
  $tags = esc_attr($args['tags']);
  $format = esc_attr($args['format']);
  $type = esc_attr($args['type']);
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
  
  $type = in_array($type, array('category', 'document')) ? $type : 'category';
  $category = get_term_by('slug', $catname, 'attachment_' . $type);

  $args = array('post_type' => 'attachment',
      'post_status' => 'any',
      'posts_per_page' => -1,
      'orderby' => $orderby,
      'order' => $sort,
      'tax_query' => array(),
      'suppress_filters' => true);
  
  if ($category) {
      $catquery = array(
          'taxonomy' => 'attachment_' . $type,
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
        $prehtml_entry = '<tr><td>';
        $posthtml_entry = "</td></tr>";
      } elseif ($format == 'liste') {
          $prehtml = '<ul class="files">';
          $posthtml = "</ul>";
          $prehtml_entry = '<li>';
          $posthtml_entry = '</li>';
      } else {
        $prehtml = '<';
        $posthtml = '/>';
        
      }

      $contentlist = '';
      $filetypes = array();
      $icon_options = get_option('rrze-downloads');

      // if "icons" then fill array with filetypes to show
      if (!empty( $icon_options )) {
        foreach ( $icon_options as $key => $value ) {
          $my_options[$key] = $value;
          if (( strpos( $key, 'icons_mimetypes_mimetype_link_icon_' ) !==false ) && ( $value <=> 'off' )) {
              $filetypes[] = substr( $key, 35 );
          }
        }
      }

      $sp = '<span class="noline">&nbsp;&nbsp;&nbsp;</span>';


      foreach ($files as $file) {

        if ( ( $icon_options['icons_mimetypes_all_mimetypes'] == 'on' ) || in_array( $myfiletype, $filetypes ) ){
          
          $size = '';

          if ( $icon_options['additional_filesize'] == 'on' ) {
            $size = size_format(filesize(get_attached_file($file->ID)), $icon_options['additional_precision']);
          }
          $excerpt = wpautop($file->post_excerpt);
          $desc = wpautop($file->post_content);
          $created = date_i18n(get_option('date_format'), strtotime($file->post_date));
          $parsed = parse_url(wp_get_attachment_url($file->ID));
          $url = dirname($parsed['path']) . '/' . rawurlencode(basename($parsed['path']));
          $myfiletype = substr( $url, strrpos( $url, '.' ) + 1 );
          $title = $file->post_title;
          $img = '';

          if ( $icon_options["icons_icon_preview"] == 'icons' ){
            $img_src = '/wp-content/plugins/rrze-downloads/assets/img/' . $myfiletype . '-icon-' . $icon_options["icons_icondimensions"] . 'x' . $icon_options["icons_icondimensions"] . '.' . $icon_options["icons_icontype"];

            if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/wordpress' . $img_src ) ) {
              
              $img_src = '..' . $img_src;
              if ( $icon_options["icons_icontype"] == 'svg' ) {

                $img = '<object height="' . $icon_options["icons_icondimensions"] . '" width="' . $icon_options["icons_icondimensions"] . '" data="' . $img_src . '" type="image/svg+xml"></object>';
              } else {
                $img = '<img src="' . $img_src . '" alt="" height="' . $icon_options["icons_icondimensions"] . '" width="' . $icon_options["icons_icondimensions"] . '">';
              }
            } else {
              $img = 'Icon is missing';
            }
            
          } elseif ( $icon_options["icons_icon_preview"] == 'previews' ) {
            $img = wp_get_attachment_image($file->ID);
            if ( !$img ) { 
              $img = 'Preview is missing';
            }
          }
          
          $addinfo = '';
          if ($showsize || $showcreated) {
              
              if ($showcreated) {
                  $addinfo .= $created;
              }
              
              if ($showsize == true) {
                  if ($addinfo)
                      $addinfo .= ', ';
                  $addinfo .= $size;
              }
              
              if ($addinfo) {
                  $addinfo = '<span class="noline">&nbsp;&nbsp;(' . $addinfo . ')</span>';
              }
          }
        }

        if ( $icon_options["icons_iconalign"] == 'left' ) {
          $link = $img . ( $icon_options["icons_icon_preview"] != 'plain' ? $sp : '' ) . $title . $addinfo;
        } else {
          $link = $title . $addinfo . ( $icon_options["icons_icon_preview"] != 'plain' ? $sp : '' ) . $img;
        }

        if ($format == 'table') {
            $contentlist .= '<tr><th>' . $title . '</th>';
            $contentlist .= $prehtml_entry . '<a href="' . $url . '">' . $link . '</a>';

            if ($showexcerpt == true) {
                $contentlist .= $excerpt;
            }
            
            if ($showcontent == true) {
                $contentlist .= $desc;
            }
            
            $contentlist .= $posthtml_entry;
        } elseif ($format == 'liste') {
            $contentlist .= $prehtml_entry . '<a href="' . $url . '">' . $link . '</a>';
            if ($showexcerpt) {
                $contentlist .= $excerpt;
            }
            
            if ($showcontent) {
                $contentlist .= $desc;
            }
            
            $contentlist .= $posthtml_entry;
        } else {
            $contentlist .= '<' . $htmlitempre . '>';
            $contentlist .= '<a href="' . $url . '">' . $link . '</a>';
            if ($showexcerpt) {
                $contentlist .= $excerpt;
            }
            
            if ($showcontent) {
                $contentlist .= $desc;
            }
            
            $contentlist .= '</' . $htmlitempost . '>';
        }
      }

      $output .= $prehtml;
      $output .= $contentlist;
      $output .= $posthtml;
      
  } else {
      if ($errormsg) {
          $output .= '<p class="attention">' . $errormsg . '</p>';
      } else {
          $output .= '<p class="info">' . __('Dowloads: Es konnten keine Dateien gefunden werden.', 'rrze-downloads') . '</p>';
      }
  }

  return $output;
}

add_shortcode('downloads', 'downloadsHandler');


