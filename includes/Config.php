<?php

namespace RRZE\Downloads;

defined('ABSPATH') || exit;

class Config {
    private static array $config = [
        'version' => '2.3.0',
        'plugin_slug' => 'rrze-downloads',
        'option_name' => 'rrze-downloads',
        'text_domain' => 'rrze-downloads',
        'domain_path' => '/languages',
        'required_php_version' => '8.2',
        'required_wp_version' => '6.8',
        'block_type' => 'rrze-downloads/downloads',
        'block_name' => 'downloads',
        'block_category' => 'rrze',
        'shortcodes' => [
            'downloads',
            'download'
        ],
        'attachment_category_taxonomy' => 'attachment_category',
        'attachment_tag_taxonomy' => 'attachment_tag',
        'attachment_document_taxonomy' => 'attachment_document',
        'attachment_taxonomies' => [
            'category' => 'attachment_category',
            'tag' => 'attachment_tag',
            'document' => 'attachment_document',
        ],
        'attachment_post_type' => 'attachment',
        'taxonomy_option_keys' => [
            'attachment_category' => 'taxonomies_attachment_category',
            'attachment_tag' => 'taxonomies_attachment_tag',
            'attachment_document' => 'taxonomies_attachment_document',
        ],
		'rrze_settings_option_name' => 'rrze_settings',
		'rrze_settings_taxonomy_option_keys' => [
			'attachment_category' => 'taxonomy_attachment_category',
			'attachment_tag' => 'taxonomy_attachment_tag',
			'attachment_document' => 'taxonomy_attachment_document',
		],
        'block_default_file_type_option' => 'icons_default_file_type',
		'taxonomy_hide_empty_filters_option' => 'taxonomies_hide_empty_filters',
        'block_file_types' => [
            'all' => [
                'search_application',
                'search_audio',
                'search_image',
                'search_text',
                'search_video',
            ],
            'application' => ['search_application'],
            'audio' => ['search_audio'],
            'image' => ['search_image'],
            'text' => ['search_text'],
            'video' => ['search_video'],
        ],
        'preview_enabled' => false,
        'settings_capability' => 'manage_options',
        'settings_menu_slug' => 'rrze-downloads',
        'settings_page_title' => 'Downloads',
        'settings_menu_title' => 'RRZE Downloads',
        'settings_title' => 'Downloads Settings',
        'icon_asset_path' => 'assets/img/',
        'mime_types' => [
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
            'zip'
        ]
    ];

    public static function get($key = '') {
        if (empty($key)) {
            return self::$config;
        }

        return self::$config[$key] ?? null;
    }

    public static function getBlockDefaultFileTypeAttributes(): array {
        $options = (array) get_option(self::get('option_name'), []);
        $optionName = self::get('block_default_file_type_option');
        $fileTypes = self::get('block_file_types');
        $selectedType = $options[$optionName] ?? 'application';

        if (!isset($fileTypes[$selectedType])) {
            $selectedType = 'application';
        }

        $attributes = array_fill_keys($fileTypes['all'], false);
        foreach ($fileTypes[$selectedType] as $attribute) {
            $attributes[$attribute] = true;
        }

        return $attributes;
    }

	public static function shouldHideEmptyTaxonomyFilters(): bool {
		$options = (array) get_option(self::get('option_name'), []);
		$optionName = self::get('taxonomy_hide_empty_filters_option');

		return !isset($options[$optionName]) || $options[$optionName] === 'on';
	}

    public static function getShortcodeSettings() {
        return [
            'block' => [
                'blocktype' => self::get('block_type'),
                'blockname' => self::get('block_name'),
                'title' => 'RRZE Downloads',
                'category' => self::get('block_category'),
                'icon' => 'download'
            ],
            'format' => [
                'field_type' => 'select',
                'values' => [
                    'list' => __('List', 'rrze-downloads'),
                    'table' => __('Table', 'rrze-downloads')
                ],
                'default' => 'list',
                'label' => __('Order by', 'rrze-downloads'),
                'type' => 'string'
            ],
            'category' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('Category', 'rrze-downloads'),
                'type' => 'string'
            ],
            'tags' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('Tags', 'rrze-downloads'),
                'type' => 'string'
            ],
            'type' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('Type', 'rrze-downloads'),
                'type' => 'string'
            ],
            'htmlpre' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('HTMLpre', 'rrze-downloads'),
                'type' => 'string'
            ],
            'htmlpost' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('HTMLpost', 'rrze-downloads'),
                'type' => 'string'
            ],
            'htmlitempre' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('HTMLitempre', 'rrze-downloads'),
                'type' => 'string'
            ],
            'htmlitempost' => [
                'field_type' => 'text',
                'default' => '',
                'label' => __('HTMLitempost', 'rrze-downloads'),
                'type' => 'string'
            ],
            'search_application' => [
                'field_type' => 'toggle',
                'label' => __('Search application', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'search_image' => [
                'field_type' => 'toggle',
                'label' => __('Search image', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'search_video' => [
                'field_type' => 'toggle',
                'label' => __('Search video', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'search_audio' => [
                'field_type' => 'toggle',
                'label' => __('Search audio', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'show_title' => [
                'field_type' => 'toggle',
                'label' => __('Show title', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'search_text' => [
                'field_type' => 'toggle',
                'label' => __('Search text', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'showsize' => [
                'field_type' => 'toggle',
                'label' => __('Show size', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => true
            ],
            'showexcerpt' => [
                'field_type' => 'toggle',
                'label' => __('Show excerpt', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'showcontent' => [
                'field_type' => 'toggle',
                'label' => __('Show content', 'rrze-downloads'),
                'type' => 'boolean',
                'checked' => false
            ],
            'orderby' => [
                'field_type' => 'select',
                'values' => [
                    'title' => __('Title', 'rrze-downloads'),
                    'date' => __('Date', 'rrze-downloads')
                ],
                'default' => 'title',
                'label' => __('Format', 'rrze-downloads'),
                'type' => 'string'
            ],
            'sort' => [
                'field_type' => 'radio',
                'values' => [
                    'ASC' => __('Ascending', 'rrze-downloads'),
                    'DESC' => __('Descending', 'rrze-downloads')
                ],
                'selected' => 'ASC',
                'default' => 'ASC',
                'label' => __('Order', 'rrze-downloads'),
                'type' => 'string'
            ]
        ];
    }

    public static function getMenuSettings() {
        return [
            'page_title' => __('Downloads', 'rrze-downloads'),
            'menu_title' => __('RRZE Downloads', 'rrze-downloads'),
            'capability' => self::get('settings_capability'),
            'menu_slug' => self::get('settings_menu_slug'),
            'title' => __('Downloads Settings', 'rrze-downloads')
        ];
    }

    public static function getHelpTab() {
        return [
            [
                'id' => self::get('plugin_slug'),
                'content' => [
                    '<p>' .
                        __('This plugin will automatically add an icon or a preview image next to links of the activated file types. If you like, you can also let the plugin add the file size of the linked file to the page.', 'rrze-downloads') .
                    '</p><p>' .
                        esc_html__('On this settings page you can choose to show an icon or a preview image will be shown and specify the icon size, icon type (white matte gif or transparent png) and the icon alignment. Click on tab "File Types Settings" to select the file types for which this plugin will be enabled. "Additional Settings" allow you to specify exceptions, format the file size and set caching options.', 'rrze-downloads') .
                    '</p>'
                ],
                'title' => __('Overview', 'rrze-downloads'),
                'sidebar' => sprintf(
                    '<p><strong>%1$s:</strong></p><p><a href="https://blogs.fau.de/webworking">RRZE Webworking</a></p><p><a href="https://github.com/RRZE-Webteam">%2$s</a></p>',
                    __('For more information', 'rrze-downloads'),
                    __('RRZE Webteam on Github', 'rrze-downloads')
                )
            ]
        ];
    }

    public static function getSections() {
        return [
            [
                'id' => 'icons',
                'title' => __('Settings', 'rrze-downloads')
            ],
            [
                'id' => 'icons_mimetypes',
                'title' => __('File Types', 'rrze-downloads')
            ],
            [
                'id' => 'taxonomies',
                'title' => __('Media Taxonomies', 'rrze-downloads')
            ],
        ];
    }

    public static function getFields() {
        $fields = [
            'icons' => [
                [
                    'name' => 'icon_preview',
                    'label' => __('Show downloads with', 'rrze-downloads'),
                    'desc' => '',
                    'type' => 'radio',
                    'default' => 'icons',
                    'options' => [
                        'icons' => __('Icons', 'rrze-downloads'),
                        'plain' => __('just plain links', 'rrze-downloads')
                    ]
                ],
                [
                    'name' => 'icondimensions',
                    'label' => __('Icon Size', 'rrze-downloads'),
                    'desc' => __('Size: width x height in pixels', 'rrze-downloads'),
                    'type' => 'select',
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
                    'name' => 'icontype',
                    'label' => __('Icon Type', 'rrze-downloads'),
                    'desc' => __('File type of the icon.', 'rrze-downloads'),
                    'type' => 'select',
                    'default' => 'svg',
                    'options' => [
                        'gif' => __('GIF', 'rrze-downloads'),
                        'png' => __('PNG', 'rrze-downloads'),
                        'svg' => __('SVG', 'rrze-downloads')
                    ]
                ],
                [
                    'name' => 'iconalign',
                    'label' => __('Align icon', 'rrze-downloads'),
                    'desc' => __('Show icon on the left or right side of the link', 'rrze-downloads'),
                    'type' => 'radio',
                    'default' => 'left',
                    'options' => [
                        'left' => __('Left', 'rrze-downloads'),
                        'right' => __('Right', 'rrze-downloads')
                    ]
                ],
                [
                    'name' => 'filesize',
                    'label' => __('Show File Size?', 'rrze-downloads'),
                    'desc' => __('Display the file size of the attachment / linked file.', 'rrze-downloads'),
                    'type' => 'checkbox',
                    'default' => 'no',
                    'options' => [
                        'yes' => __('yes', 'rrze-downloads'),
                        'no' => __('no', 'rrze-downloads')
                    ]
                ],
                [
                    'name' => 'precision',
                    'label' => __('Precision (decimals)', 'rrze-downloads'),
                    'desc' => __('Sizes less than 1 kB will always have 0 decimals.', 'rrze-downloads'),
                    'type' => 'select',
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
                    'name' => 'default_file_type',
                    'label' => __('Default file type for Downloads blocks', 'rrze-downloads'),
                    'desc' => __('Used when a new Downloads block is inserted or no file type is selected.', 'rrze-downloads'),
                    'type' => 'select',
                    'default' => 'application',
                    'options' => [
                        'all' => __('All file types', 'rrze-downloads'),
                        'application' => __('PDF and application files', 'rrze-downloads'),
                        'audio' => __('Audio files', 'rrze-downloads'),
                        'image' => __('Images', 'rrze-downloads'),
                        'text' => __('Text files', 'rrze-downloads'),
                        'video' => __('Video files', 'rrze-downloads'),
                    ],
                ]
            ],
            'icons_mimetypes' => [
                [
                    'name' => 'all_mimetypes',
                    'label' => __('Enable icons or previews for all file types', 'rrze-downloads'),
                    'desc' => __('Replaces the individual file type selections below.', 'rrze-downloads'),
                    'type' => 'checkbox',
                    'default' => 'no',
                    'options' => [
                        'yes' => __('yes', 'rrze-downloads'),
                        'no' => __('no', 'rrze-downloads')
                    ]
                ]
            ],
            'taxonomies' => [
				[
					'name' => 'hide_empty_filters',
					'label' => __('Filter', 'rrze-downloads'),
					'checkbox_label' => __('Empty taxonomies are hidden', 'rrze-downloads'),
					'desc' => '',
					'type' => 'checkbox',
					'default' => 'on'
				],
                [
                    'name' => 'attachment_document',
                    'label' => __('Media Documents', 'rrze-downloads'),
                    'checkbox_label' => __('Register Media Documents', 'rrze-downloads'),
                    'desc' => '',
                    'type' => 'checkbox',
                    'default' => 'on'
                ],
                [
                    'name' => 'attachment_category',
                    'label' => __('Media Categories', 'rrze-downloads'),
                    'checkbox_label' => __('Register Media Categories', 'rrze-downloads'),
                    'desc' => '',
                    'type' => 'checkbox',
                    'default' => 'on'
                ],
                [
                    'name' => 'attachment_tag',
                    'label' => __('Media Tags', 'rrze-downloads'),
                    'checkbox_label' => __('Register Media Tags', 'rrze-downloads'),
                    'desc' => '',
                    'type' => 'checkbox',
                    'default' => 'on'
                ]
            ]
        ];

        if (self::get('preview_enabled')) {
            $fields['icons'][0]['options'] = array_merge(
                array_slice($fields['icons'][0]['options'], 0, 1),
                ['previews' => __('Preview images', 'rrze-downloads')],
                array_slice($fields['icons'][0]['options'], 1, 1)
            );
        }

        foreach (self::get('mime_types') as $mimeType) {
            $fields['icons_mimetypes'][] = [
                'name' => 'mimetype_link_icon_' . $mimeType,
                'label' => $mimeType,
                'desc' => __('Add an icon / a preview', 'rrze-downloads'),
                'type' => 'checkbox',
                'default' => 'no',
                'options' => [
                    'yes' => __('yes', 'rrze-downloads'),
                    'no' => __('no', 'rrze-downloads')
                ]
            ];
        }

        return $fields;
    }
}
