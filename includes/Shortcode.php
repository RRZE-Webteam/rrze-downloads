<?php
namespace RRZE\Downloads;

use function RRZE\Downloads\Config\getShortcodeSettings;

class Shortcode {
    private $settings = '';
    private $pluginname = '';

    /**
     * Shortcode-Klasse wird instanziiert.
     */
    public function __construct() {
        $this->settings = getShortcodeSettings();
        $this->pluginname = $this->settings['block']['blockname'];
        add_action('admin_head', [$this, 'setMCEConfig']);
        add_filter('mce_external_plugins', [$this, 'addMCEButtons']);
        add_shortcode( 'downloads', [ $this, 'shortcodeOutput' ]);
        add_shortcode( 'download', [ $this, 'shortcodeOutput' ]);
    }



    public function shortcodeOutput( $atts ) {
        error_log('Shortcode: ' . print_r($atts, true));
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
            "showsize" => false,
            "showcreated" => false,
            "showexcerpt" => false,
            "showcontent" => false,
            "errormsg" => '',
            "orderby" => 'title',
            "sort" => 'asc'
        ], $atts, 'downloads');

        $output = '';
        $sp = '&nbsp;&nbsp;';
  
        $category = esc_attr($atts['category']);
        $tags = esc_attr($atts['tags']);
        $format = esc_attr($atts['format']);
        $type = esc_attr($atts['type']);
        $htmlpre = esc_attr($atts['htmlpre']);
        $htmlpost = esc_attr($atts['htmlpost']);
        $htmlitempre = esc_attr($atts['htmlitempre']);
        $htmlitempost = esc_attr($atts['htmlitempost']);
        $errormsg = esc_attr($atts['errormsg']);
        $orderby = esc_attr($atts['orderby']);
        $sort = esc_attr($atts['sort']);

        $search_application = filter_var($atts['search_application'], FILTER_VALIDATE_BOOLEAN);
        $search_image = filter_var($atts['search_image'], FILTER_VALIDATE_BOOLEAN);
        $search_video = filter_var($atts['search_video'], FILTER_VALIDATE_BOOLEAN);
        $search_audio = filter_var($atts['search_audio'], FILTER_VALIDATE_BOOLEAN);
        $search_text = filter_var($atts['search_text'], FILTER_VALIDATE_BOOLEAN);
        $showsize = filter_var($atts['showsize'], FILTER_VALIDATE_BOOLEAN);
        $showcreated = filter_var($atts['showcreated'], FILTER_VALIDATE_BOOLEAN);
        $showexcerpt = filter_var($atts['showexcerpt'], FILTER_VALIDATE_BOOLEAN);
        $showcontent = filter_var($atts['showcontent'], FILTER_VALIDATE_BOOLEAN);

        $orderby = !empty($orderby) && in_array(strtolower($orderby), array('title', 'date')) ? strtolower($orderby) : 'title';
        $sort = !empty($sort) && in_array(strtoupper($sort), array('ASC', 'DESC')) ? strtoupper($sort) : 'ASC';

        $type = in_array($type, array('category', 'document')) ? $type : 'category';
        $category = get_term_by('slug', $category, 'attachment_' . $type);

        $atts = array('post_type' => 'attachment',
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
            $atts['tax_query'][] = $catquery;
        }
  
        if ($tags) {
            $tagquery = array(
                'taxonomy' => 'attachment_tag',
                'field' => 'slug',
                'terms' => explode(',', $tags),
            );
            $atts['tax_query'][] = $tagquery;
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
            $atts['post_mime_type'] = $mimetype;
        } else {
            $atts['post_mime_type'] = "application";
        }

        $files = get_posts($atts);

        if ($files) {
            $prehtml = '';
            $posthtml = '';

            if ($format == 'table') {
                $prehtml = '<table class="files">';
                $posthtml = "</table>";
                $prehtml_entry = '<tr><td>';
                $posthtml_entry = "</td></tr>";
            } elseif ($format == 'list') {
                $prehtml = '<ul class="files">';
                $posthtml = "</ul>";
                $prehtml_entry = '<li>';
                $posthtml_entry = '</li>';
            } else {
                $prehtml = '';
                $posthtml = '';
                
            }

            $contentlist = '';
            $filetypes = array();
            $icon_options = get_option('rrze-downloads');

            // if "icons" then fill array with filetypes to show
            $icon_options_exist = false;
            if (!empty( $icon_options )) {
                $icon_options_exist = true;
                foreach ( $icon_options as $key => $value ) {
                    $my_options[$key] = $value;
                    if (( strpos( $key, 'icons_mimetypes_mimetype_link_icon_' ) !==false ) && ( $value <=> 'off' )) {
                        $filetypes[] = substr( $key, 35 );
                    }
                }
            }

            foreach ($files as $file) {
                $parsed = parse_url(wp_get_attachment_url($file->ID));
                $url = dirname($parsed['path']) . '/' . rawurlencode(basename($parsed['path']));
                $myfiletype = substr( $url, strrpos( $url, '.' ) + 1 );
                
                $size = '';

                if ( ($icon_options_exist && $icon_options['icons_filesize'] == 'on') || $showsize ) {
                    $precision = ( $icon_options_exist && $icon_options['icons_filesize'] == 'on' ? $icon_options['icons_precision'] : 2);
                    $size = size_format( filesize(get_attached_file($file->ID)), $precision );
                }

                $excerpt = wpautop($file->post_excerpt);
                $desc = wpautop($file->post_content);
                $created = date_i18n(get_option('date_format'), strtotime($file->post_date));
                $title = $file->post_title;
                $img = '';

                $addinfo = '';
                if ($size || $showcreated) {
                if ($showcreated) {
                    $addinfo .= $created;
                }
                
                if ($size) {
                    if ($addinfo)
                        $addinfo .= ', ';
                    $addinfo .= $size;
                }
                
                if ($addinfo) {
                    $addinfo = $sp . '(' . $addinfo . ')';
                }
                }

                $link = $title . $addinfo;

                if ( ($icon_options_exist && $icon_options['icons_mimetypes_all_mimetypes'] == 'on')  ||  in_array( $myfiletype, $filetypes ) ){
                    if ( $icon_options["icons_icon_preview"] == 'icons' ){
                        $img_src = 'assets/img/' . $myfiletype . '-icon-' . $icon_options["icons_icondimensions"] . 'x' . $icon_options["icons_icondimensions"] . '.' . $icon_options["icons_icontype"];
                        if ( file_exists( plugin_dir_path ( __DIR__ ) . $img_src ) ) {
                            $img_src =  get_site_url() . '/wp-content/plugins/rrze-downloads/' . $img_src;
                            $img = '<img src="' . $img_src . '" alt="' . strtoupper($myfiletype) . '" height="' . $icon_options["icons_icondimensions"] . '" width="' . $icon_options["icons_icondimensions"] . '" style="box-shadow: none; margin-bottom: '. ($icon_options["icons_icondimensions"] / 4) . 'px;">';
                        } else {
                            $img = 'Icon is missing';
                        }
                    } elseif ( $icon_options["icons_icon_preview"] == 'previews' ) {
                        $img = wp_get_attachment_image($file->ID);
                        if ( !$img ) { 
                            $img = 'Preview is missing';
                        }
                    }
                    
                    $link = ( $img ? ( $icon_options["icons_iconalign"] == 'left' ? $img . $sp . $link : $link . $sp . $img ) : $link );
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
                } elseif ($format == 'list') {
                    $contentlist .= $prehtml_entry . '<a href="' . $url . '">' . $link . '</a>';
                    if ($showexcerpt) {
                        $contentlist .= $excerpt;
                    }
                    if ($showcontent) {
                        $contentlist .= $desc;
                    }
                    $contentlist .= $posthtml_entry;
                } else {
                    $contentlist .= ($htmlitempre?'<' . $htmlitempre . '>':'');
                    $contentlist .= '<a href="' . $url . '">' . $link . '</a>';
                    if ($showexcerpt) {
                        $contentlist .= $excerpt;
                    }
                    if ($showcontent) {
                        $contentlist .= $desc;
                    }
                    $contentlist .= ($htmlitempost?'</' . $htmlitempost . '>':'');
                    $contentlist .= ($htmlitempre?'':'<br/>');
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

    public function setMCEConfig(){
        $shortcode = '';
        foreach($this->settings as $att => $details){
            if ($att != 'block'){
                $shortcode .= ' ' . $att . '=""';
            }
        }
        $shortcode = '[' . $this->pluginname . ' ' . $shortcode . ']';
        ?>
        <script type='text/javascript'>
            tmp = [{
                'name': <?php echo json_encode($this->pluginname); ?>,
                'title': <?php echo json_encode($this->settings['block']['title']); ?>,
                'icon': <?php echo json_encode($this->settings['block']['tinymce_icon']); ?>,
                'shortcode': <?php echo json_encode($shortcode); ?>,
            }];
            phpvar = (typeof phpvar === 'undefined' ? tmp : phpvar.concat(tmp)); 
        </script> 
        <?php        
    }

    public function addMCEButtons($pluginArray){
        if (current_user_can('edit_posts') &&  current_user_can('edit_pages')) {
            $pluginArray['rrze_shortcode'] = plugins_url('../assets/js/tinymce-shortcodes.js', plugin_basename(__FILE__));
        }
        return $pluginArray;
    }
}
