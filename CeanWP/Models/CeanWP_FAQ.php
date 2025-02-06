<?php

namespace CeanWP\Models;

use CeanWP\Libs\MetaBox;
use CeanWP\Types\Models;
use CeanWP\Traits\Models as ModelsTrait;

class CeanWP_FAQ implements Models
{
    use ModelsTrait;

    const POST_TYPE = 'cean_faq';
    const META_PREFIX = '_cean_faq_';
    const FAQ_CATEGORIES = [
        'general' => 'General',
        'technical' => 'Technical',
        'billing' => 'Billing & Payments',
        'account' => 'Account Related',
    ];

    static CeanWP_FAQ $instance;

    static function get_instance(): self
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new self();

        // Register post type and meta boxes
        add_action('init', [self::$instance, 'register_post_type']);
        add_action("save_post_".self::POST_TYPE, [self::$instance, 'save_post']);

        // Add custom admin table columns
        add_filter('manage_' . self::POST_TYPE . '_posts_columns', [self::$instance, 'set_custom_columns']);
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', [self::$instance, 'custom_column_content'], 10, 2);
        self::$instance->setup_metabox();

        return self::$instance;
    }

    static function get_post_type_args(): array
    {
        return array(
            'labels' => array(
                'name'               => __('FAQs', 'cean-wp-theme'),
                'singular_name'      => __('FAQ', 'cean-wp-theme'),
                'add_new'            => __('Add New FAQ', 'cean-wp-theme'),
                'add_new_item'       => __('Add New FAQ', 'cean-wp-theme'),
                'edit_item'          => __('Edit FAQ', 'cean-wp-theme'),
                'view_item'          => __('View FAQ', 'cean-wp-theme'),
                'search_items'       => __('Search FAQs', 'cean-wp-theme'),
                'not_found'          => __('No FAQs found', 'cean-wp-theme'),
            ),
            'public'              => true,
            'show_ui'             => true,
            'menu_icon'           => 'dashicons-editor-help',
            'supports'            => ['title', 'editor'],
            'show_in_rest'        => true,
            'has_archive'         => true,
            'rewrite'             => array('slug' => 'faqs'),
        );
    }

    function set_custom_columns(array $columns): array
    {
        $new_columns = [];

        // Include default columns
        if (isset($columns['cb'])) {
            $new_columns['cb'] = $columns['cb'];
        }

        $new_columns['title'] = __('Question', 'cean-wp-theme');
        $new_columns['category'] = __('Category', 'cean-wp-theme');
        $new_columns['date'] = __('Date', 'cean-wp-theme');

        return $new_columns;
    }

    function custom_column_content(string $column, int $post_id): void
    {
        switch ($column) {
            case 'category':
                $category = get_post_meta($post_id, self::META_PREFIX . 'category', true);
                echo esc_html(self::FAQ_CATEGORIES[$category] ?? '');
                break;
        }
    }

    function setup_metabox(): void
    {
        $meta_box = new MetaBox('faq_details', 'FAQ Details', self::POST_TYPE);

        $meta_box->add_field(self::META_PREFIX . 'category', 'Category', 'select', self::FAQ_CATEGORIES);
        $meta_box->add_field(self::META_PREFIX . 'order', 'Display Order', 'number');
//        $meta_box->add_field(self::META_PREFIX . 'wp_media', 'media', 'wp_media', [], ['multiple' => true]);

        $this->register_metabox($meta_box);
    }

    static function get_faqs($count = -1, $category = null): array
    {
        $args = [
            'post_type' => self::POST_TYPE,
            'posts_per_page' => $count,
            'orderby' => 'meta_value_num',
            'meta_key' => self::META_PREFIX . 'order',
            'order' => 'ASC',
        ];

        if ($category) {
            $args['meta_query'] = [
                [
                    'key' => self::META_PREFIX . 'category',
                    'value' => $category,
                ]
            ];
        }

        $faqs = get_posts($args);

        return array_map(function ($faq) {
            return [
                'title' => $faq->post_title,
                'content' => $faq->post_content,
            ];
        }, $faqs);
    }
}