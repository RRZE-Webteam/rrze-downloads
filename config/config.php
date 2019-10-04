<?php

namespace RRZE\Downloads\Config;


defined('ABSPATH') || exit;


/**
 * @var array	array of mimetypes
 */
$mime_types = array(
  '3g2', '3gp', 
  'ai', 'air', 'asf', 'avi',
  'bib',
  'cls', 'csv',
  'deb', 'djvu', 'dmg', 'doc', 'docx', 'dwf', 'dwg',
  'eps', 'epub', 'exe',
  'f', 'f77', 'f90', 'flac', 'flv',
  'gif', 'gz',
  'ico', 'indd', 'iso',
  'jpg', 'jpeg',
  'key',
  'log',
  'm4a', 'm4v', 'midi', 'mkv', 'mov', 'mp3', 'mp4', 'mpeg', 'mpg', 'msi',
  'odp', 'ods', 'odt', 'oga', 'ogg', 'ogv',
  'pdf', 'png', 'pps', 'ppsx', 'ppt', 'pptx', 'psd', 'pub', 'py',
  'qt',
  'ra', 'ram', 'rar', 'rm', 'rpm', 'rtf', 'rv',
  'skp', 'spx', 'sql', 'sty',
  'tar', 'tex', 'tgz', 'tiff', 'ttf', 'txt',
  'vob',
  'wav', 'wmv',
  'xls', 'xlsx', 'xml', 'xpi',
  'zip',
);

/**
 * Gibt der Name der Option zurück.
 * @return array [description]
 */
function getOptionName() {
    return 'rrze-downloads';
}

/**
 * Gibt die Einstellungen des Menus zurück.
 * @return array [description]
 */
function getMenuSettings() {
    return [
       'page_title'    => __('Downloads', 'rrze-downloads'),
        'menu_title'    => __('RRZE Downloads', 'rrze-downloads'),
        'capability'    => 'manage_options',
        'menu_slug'     => 'rrze-downloads',
        'title'         => __('Downloads Settings', 'rrze-downloads'),
    ];
}

/**
 * Gibt die Einstellungen der Inhaltshilfe zurück.
 * @return array [description]
 */
function getHelpTab() {
    return [
        [
            'id'        => 'rrze-downloads',
            'content'   => ['<p>' .
      								sprintf( __( 'This plugin will automatically add an icon or a preview image next to links of the activated file types. If you like, you can also let the plugin add the file size of the linked file to the page.', 'rrze-downloads' ), 'http://wordpress.org/plugins/mimetypes-link-icons/" target="_blank" class="ext-link' ) . '</p>
      								<p>' . esc_html__( 'On this settings page you can choose to show an icon or a preview image will be shown and specify the icon size, icon type (white matte gif or transparent png) and the icon alignment. Click on tab "File Types Settings" to select the file types for which this plugin will be enabled. "Additional Settings" allow you to specify exceptions, format the file size and set caching options.', 'rrze-downloads' ) . '</p>'
            ],
            'title'     => __('Overview', 'downloads'),
            'sidebar'   => sprintf('<p><strong>%1$s:</strong></p><p><a href="https://blogs.fau.de/webworking">RRZE Webworking</a></p><p><a href="https://github.com/RRZE Webteam">%2$s</a></p>', __('For more information', 'rrze-downloads'), __('RRZE Webteam on Github', 'rrze-downloads'))
        ]
    ];
}

/**
 * Gibt die Einstellungen der Optionsbereiche zurück.
 * @return array [description]
 */
function getSections() {
    return [
      [
        'id'    => 'icons',
        'title' => __('Icons Settings', 'rrze-downloads')
      ],
      [
        'id'    => 'icons_mimetypes',
        'title' => __('File Types Settings', 'rrze-downloads')
      ],
      [
        'id'    => 'additional',
        'title' => __('Additional Settings', 'rrze-downloads')
      ]
    ];
}

/**
 * Gibt die Einstellungen der Optionsfelder zurück.
 * @return array [description]
 */
function getFields() {
  global $mime_types;
  $ret = [
    'icons' => [
      [
        'name'    => 'icon_preview',
        'label'   => __('Show downloads with', 'rrze-downloads'),
        'desc'    => __('Choose whether to show icons or preview images next to each download', 'rrze-downloads'),
        'type'    => 'radio',
        'default' => 'icons',
        'options' => [
          'icons' => __('Icons', 'rrze-downloads'),
          'previews' => __('Preview images', 'rrze-downloads'),
          'plain' => __('just plain links', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'icondimensions',
        'label'   => __('Image Size', 'rrze-downloads'),
        'desc'    => __('Size: width x height in pixels', 'rrze-downloads'),
        'type'    => 'select',
        'default' => '24',
        'options' => [
          '16' => __('16 x 16', 'rrze-downloads'),
          '24' => __('24 x 24', 'rrze-downloads'),
          '48' => __('48 x 48', 'rrze-downloads'),
          '64' => __('64 x 64', 'rrze-downloads'),
          '128' => __('128 x 128', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'icontype',
        'label'   => __('Image Type', 'rrze-downloads'),
        'desc'    => __('File type of the icon.', 'rrze-downloads'),
        'type'    => 'select',
        'default' => 'svg',
        'options' => [
          'gif'  => __('GIF', 'rrze-downloads'),
          'png' => __('PNG', 'rrze-downloads'),
          'svg'  => __('SVG', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'iconalign',
        'label'   => __('Align icon', 'rrze-downloads'),
        'desc'    => __('Show icon on the left or right side of the link', 'rrze-downloads'),
        'type'    => 'radio',
        'default' => 'left',
        'options' => [
          'left' => __('Left', 'rrze-downloads'),
          'right'  => __('Right', 'rrze-downloads')
        ]              
      ]
    ],
    'icons_mimetypes' => [
      [
        'name'    => 'all_mimetypes',
        'label'   => __('Select all file types', 'rrze-downloads'),
        'desc'    => __('Add an icon to all file types', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'no',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ]
    ],
    'additional' => [
      [
        'name'    => 'use_classnames',
        'label'   => __('Enable Classnames?', 'rrze-downloads'),
        'desc'    => __('Use this option to disable the mime type links (ie: around an image or caption) excluding the following classname(s):', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'no',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'classnames',
        'label'   => __('Classname(s)', 'rrze-downloads'),
        'desc'    => __('Enter one or more classnames seperated by comma "," to exclude them.', 'rrze-downloads'),
        'type'    => 'text',
        'default' => 'wp-caption'
      ],
      [
        'name'    => 'filesize',
        'label'   => __('Show File Size?', 'rrze-downloads'),
        'desc'    => __('Display the file size of the attachment / linked file.', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'no',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'precision',
        'label'   => __('Precision (decimals)', 'rrze-downloads'),
        'desc'    => __('Sizes less than 1 kB will always have 0 decimals.', 'rrze-downloads'),
        'type'    => 'select',
        'default' => '2',
        'options' => [
          '0' => __('0', 'rrze-downloads'),
          '1' => __('1', 'rrze-downloads'),
          '2' => __('2', 'rrze-downloads'),
          '3' => __('3', 'rrze-downloads'),
          '4' => __('4', 'rrze-downloads'),
          '5' => __('5', 'rrze-downloads')
        ]
      ],      
      [
        'name'    => 'cache',
        'label'   => __('Cache retrieved file sizes.', 'rrze-downloads'),
        'desc'    => __('If the file sizes of the files you link to do not change very often, it is recommended to cache the results for a faster page loading.', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'yes',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ],      
      [
        'name'    => 'cachetime',
        'label'   => __('Time to cache:', 'rrze-downloads'),
        'desc'    => __('Amount of time to cache retrieved file sizes: ', 'rrze-downloads'),
        'type'    => 'select',
        'default' => '604800',
        'options' => [
          '3600' => __('1 hour', 'rrze-downloads'),
          '86400' => __('1 day', 'rrze-downloads'),
          '604800' => __('1 week', 'rrze-downloads'),
          '1209600' => __('2 weeks', 'rrze-downloads'),
          '1814400' => __('3 weeks', 'rrze-downloads'),
          '2419200' => __('4 weeks', 'rrze-downloads')
        ]
      ],      
      [
        'name'    => 'replacement',
        'label'   => __('Replacement Mode', 'rrze-downloads'),
        'desc'    => __('Switch to asynchronous replacement if your theme conflicts with this plugin. Asynchronous replacement uses JavaScript instead of PHP to find your links.', 'rrze-downloads'),
        'type'    => 'radio',
        'default' => 'synchronous',
        'options' => [
          'synchronous' => __('synchronous', 'rrze-downloads'),
          'asynchronous' => __('asynchronous', 'rrze-downloads')
        ]
      ],      
      [
        'name'    => 'asynchronous_debug',
        'label'   => __('Enable Debug Mode?', 'rrze-downloads'),
        'desc'    => __('Tick this box for debugging if using asynchronous replacement.', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'no',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ]      
    ]
  ];
    
    
  foreach ($mime_types as $mt) {
    $ret['icons_mimetypes'][] = [
      'name'    => 'mimetype_link_icon_' . $mt,
      'label'   => __($mt, 'rrze-downloads'),
      'desc'    => __('Add an icon', 'rrze-downloads'),
      'type'    => 'checkbox',
      'default' => 'no',
      'options' => [
        'yes' => __('yes', 'rrze-downloads'),
        'no' => __('no', 'rrze-downloads')
      ]
    ];
  } 
  
  return $ret;
}

