<?php

namespace RRZE\Downloads\Config;


defined('ABSPATH') || exit;

// Auf true setzen, wenn der Server Preview Bilder aus PDFs und z.B. DOCs erstellen kann:
define('PREVIEW_ENABLED', false);


function getShortcodeSettings(){
	return [
		'block' => [
			'blocktype' => 'rrze-downloads/downloads', 
			'blockname' => 'downloads',
			'title' => 'RRZE Downloads',
			'category' => 'widgets',
			'icon' => 'download',
			'show_block' => 'content', // 'right' or 'content' 
			'message' => __( 'Find the settings on the right side', 'rrze-downloads' )
    ],
    'format' => [
			'field_type' => 'select',
			'values' => [
				'list' => __( 'List', 'rrze-downloads' ),
				'table' => __( 'Table', 'rrze-downloads' )
			],
			'default' => 'list',
			'label' => __( 'Order by', 'rrze-downloads' ),
			'type' => 'string'
    ],
		'category' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'Category', 'rrze-downloads' ),
			'type' => 'string'
		],
		'tags' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'Tags', 'rrze-downloads' ),
			'type' => 'string'
		],
		'type' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'Type', 'rrze-downloads' ),
			'type' => 'string'
		],
		'htmlpre' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'HTMLpre', 'rrze-downloads' ),
			'type' => 'string'
		],
		'htmlpost' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'HTMLpost', 'rrze-downloads' ),
			'type' => 'string'
		],
		'htmlitempre' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'HTMLitempre', 'rrze-downloads' ),
			'type' => 'string'
		],
		'htmlitempost' => [
			'field_type' => 'text',
			'default' => '',
			'label' => __( 'HTMLitempost', 'rrze-downloads' ),
			'type' => 'string'
    ],
    'search_application' => [
      'field_type' => 'toggle',
      'label' => __( 'Search application', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'search_image' => [
      'field_type' => 'toggle',
      'label' => __( 'Search image', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'search_video' => [
      'field_type' => 'toggle',
      'label' => __( 'Search video', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'search_audio' => [
      'field_type' => 'toggle',
      'label' => __( 'Search audio', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'show_title' => [
      'field_type' => 'toggle',
      'label' => __( 'Show title', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'search_text' => [
      'field_type' => 'toggle',
      'label' => __( 'Search text', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'showsize' => [
      'field_type' => 'toggle',
      'label' => __( 'Show size', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => TRUE
    ],
    'showexcerpt' => [
      'field_type' => 'toggle',
      'label' => __( 'Show excerpt', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
    'showcontent' => [
      'field_type' => 'toggle',
      'label' => __( 'Show content', 'rrze-downloads' ),
      'type' => 'boolean',
      'checked'   => FALSE
    ],
		'orderby' => [
			'field_type' => 'select',
			'values' => [
				'title' => __( 'Title', 'rrze-downloads' ),
				'date' => __( 'Date', 'rrze-downloads' )
			],
			'default' => 'title',
			'label' => __( 'Format', 'rrze-downloads' ),
			'type' => 'string'
    ],
    'sort' => [
			'field_type' => 'radio',
			'values' => [
				'ASC' => __( 'Ascending', 'rrze-downloads' ),
				'DESC' => __( 'Descending', 'rrze-downloads' )
			],
			'selected' => 'ASC',
			'default' => 'ASC',
			'label' => __( 'Order', 'rrze-downloads' ),
			'type' => 'string'
		]
	];
}


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
        'title' => __('Settings', 'rrze-downloads')
      ],
      [
        'id'    => 'icons_mimetypes',
        'title' => __('File Types', 'rrze-downloads')
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
        // 'desc'    => __('Choose whether to show icons or not next to each download.', 'rrze-downloads'),
        'desc'    => '',
        'type'    => 'radio',
        'default' => 'icons',
        'options' => [
          'icons' => __('Icons', 'rrze-downloads'),
          // 'previews' => __('Preview images', 'rrze-downloads',
          'plain' => __('just plain links', 'rrze-downloads')
        ]
      ],
      [
        'name'    => 'icondimensions',
        'label'   => __('Icon Size', 'rrze-downloads'),
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
        'label'   => __('Icon Type', 'rrze-downloads'),
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
      ]
    ],
    'icons_mimetypes' => [
      [
        'name'    => 'all_mimetypes',
        'label'   => __('Select all file types', 'rrze-downloads'),
        'desc'    => __('Add an icon / a preview to all file types', 'rrze-downloads'),
        'type'    => 'checkbox',
        'default' => 'no',
        'options' => [
          'yes' => __('yes', 'rrze-downloads'),
          'no' => __('no', 'rrze-downloads')
        ]
      ]
    ]
  ];

  if (PREVIEW_ENABLED) {
    $ret['icons'][0]['options'] = array_merge( array_slice($ret['icons'][0]['options'], 0, 1), array('previews' => __('Preview images', 'rrze-downloads')), array_slice($ret['icons'][0]['options'], 1, 1) );
  }
    
  foreach ($mime_types as $mt) {
    $ret['icons_mimetypes'][] = [
      'name'    => 'mimetype_link_icon_' . $mt,
      'label'   => $mt,
      'desc'    => __('Add an icon / a preview', 'rrze-downloads'),
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

