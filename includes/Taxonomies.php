<?php

namespace RRZE\Downloads;

defined('ABSPATH') || exit;

class Taxonomies {
    private array $registeredTaxonomies = [];

    public function loaded(): void {
        require_once __DIR__ . '/Taxonomies/attachment-category.php';
        require_once __DIR__ . '/Taxonomies/attachment-document.php';
        require_once __DIR__ . '/Taxonomies/attachment-tag.php';

        add_action('init', [$this, 'registerFallbackTaxonomies'], 99);
    }

    public function registerFallbackTaxonomies(): void {
        $categoryTaxonomy = Config::get('attachment_category_taxonomy');
        $documentTaxonomy = Config::get('attachment_document_taxonomy');
        $tagTaxonomy = Config::get('attachment_tag_taxonomy');

        if ($this->shouldRegister($documentTaxonomy)) {
            Taxonomies\AttachmentDocument\set();
            $this->registeredTaxonomies[] = $documentTaxonomy;
            add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentDocument\register');
        }

        if ($this->shouldRegister($categoryTaxonomy)) {
            Taxonomies\AttachmentCategory\set();
            $this->registeredTaxonomies[] = $categoryTaxonomy;
            add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentCategory\register');
        }

        if ($this->shouldRegister($tagTaxonomy)) {
            Taxonomies\AttachmentTag\set();
            $this->registeredTaxonomies[] = $tagTaxonomy;
            add_action('admin_init', 'RRZE\Downloads\Taxonomies\AttachmentTag\register');
        }

        if (is_admin() && !empty($this->registeredTaxonomies)) {
            new Taxonomies\Media($this->registeredTaxonomies);
        }
    }

    public static function isAvailable(string $taxonomy): bool {
        return taxonomy_exists($taxonomy)
            && is_object_in_taxonomy(Config::get('attachment_post_type'), $taxonomy);
    }

    public static function getBlockTaxonomies(): array {
        return [
            'category' => self::isAvailable(Config::get('attachment_category_taxonomy')),
            'document' => self::isAvailable(Config::get('attachment_document_taxonomy')),
            'tag' => self::isAvailable(Config::get('attachment_tag_taxonomy')),
        ];
    }

    public static function isManaged(string $taxonomy): bool {
        return in_array($taxonomy, Config::get('attachment_taxonomies'), true)
            && self::isAvailable($taxonomy);
    }

    public static function isProvidedByRrzeSettings(string $taxonomy): bool {
        return self::isRrzeSettingsActive() && self::isAvailable($taxonomy);
    }

    private function shouldRegister(string $taxonomy): bool {
        return $this->isEnabled($taxonomy) && !self::isAvailable($taxonomy);
    }

    private function isEnabled(string $taxonomy): bool {
        $optionKeys = Config::get('taxonomy_option_keys');
        $optionKey = $optionKeys[$taxonomy] ?? '';

        if ($optionKey === '') {
            return false;
        }

        $options = (array) get_option(Config::get('option_name'), []);

        return !isset($options[$optionKey]) || $options[$optionKey] === 'on';
    }

    private static function isRrzeSettingsActive(): bool {
        $activePlugins = (array) get_option('active_plugins', array());

        if (is_multisite()) {
            $activePlugins = array_merge(
                $activePlugins,
                array_keys((array) get_site_option('active_sitewide_plugins', array()))
            );
        }

        foreach ($activePlugins as $plugin) {
            if (str_starts_with($plugin, 'rrze-settings/')) {
                return true;
            }
        }

        return false;
    }
}
