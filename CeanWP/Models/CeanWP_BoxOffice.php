<?php

namespace CeanWP\Models;

use CeanWP\Libs\MetaBox;
use CeanWP\Types\Models;
use CeanWP\Traits\Models as ModelsTrait;

class CeanWP_BoxOffice implements Models
{
    use ModelsTrait;

    const POST_TYPE = 'cean_box_office';
    const META_PREFIX = '_cean_box_office_';

    static CeanWP_BoxOffice $instance;

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
                'name'               => __('Box Office Reports', 'cean-wp-theme'),
                'singular_name'      => __('Box Office Report', 'cean-wp-theme'),
                'add_new'           => __('Add New Report', 'cean-wp-theme'),
                'add_new_item'      => __('Add New Box Office Report', 'cean-wp-theme'),
                'edit_item'         => __('Edit Box Office Report', 'cean-wp-theme'),
                'view_item'         => __('View Box Office Report', 'cean-wp-theme'),
                'search_items'      => __('Search Box Office Reports', 'cean-wp-theme'),
                'not_found'         => __('No reports found', 'cean-wp-theme'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'menu_icon'           => 'dashicons-chart-bar',
            'supports'            => ['title'],
            'show_in_rest'        => true,
            'has_archive'         => 'box-office-reports',
            'query_var'           => true,
            'rewrite'             => array(
                'slug' => 'box-office-reports',
                'with_front' => true,
                'feeds' => true
            ),

        );
    }

    function flush_rewrite_rules(): void
    {
        // First, ensure the post type is registered
        $this->register_post_type();

        // Then flush rewrite rules
        flush_rewrite_rules();
    }

    function set_custom_columns(array $columns): array
    {
        $new_columns = [];

        if (isset($columns['cb'])) {
            $new_columns['cb'] = $columns['cb'];
        }

        $new_columns['title'] = __('Report Date', 'cean-wp-theme');
        $new_columns['report_image'] = __('Report Image', 'cean-wp-theme');
        $new_columns['pdf_url'] = __('PDF URL', 'cean-wp-theme');
        $new_columns['date'] = __('Published', 'cean-wp-theme');

        return $new_columns;
    }

    function custom_column_content(string $column, int $post_id): void
    {
        switch ($column) {
            case 'report_image':
                $image_id = get_post_meta($post_id, self::META_PREFIX . 'report_image', true);
                if ($image_id) {
                    echo wp_get_attachment_image($image_id, [100, 100]);
                }
                break;
            case 'pdf_url':
                $pdf_url = get_post_meta($post_id, self::META_PREFIX . 'pdf_url', true);
                if ($pdf_url) {
                    echo '<a href="' . esc_url($pdf_url) . '" target="_blank">View PDF</a>';
                }
                break;
        }
    }

    function setup_metabox(): void
    {
        $meta_box = new MetaBox('box_office_details', 'Box Office Report Details', self::POST_TYPE);

        $meta_box->add_field(
            self::META_PREFIX . 'report_image',
            'Report Image',
            'wp_media',
            [],
            ['multiple' => true, 'required' => true]
        );

        $meta_box->add_field(
            self::META_PREFIX . 'pdf_url',
            'PDF Download URL',
            'url'
        );

        $meta_box->add_field(
            self::META_PREFIX . 'report_date',
            'Report Date Range',
            'text',
            [],
            ['placeholder' => 'e.g., February 23rd - 25th, 2024']
        );

        $this->register_metabox($meta_box);
    }

    static function get_reports($count = -1): array
    {
        $args = [
            'post_type' => self::POST_TYPE,
            'posts_per_page' => $count,
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        $reports = get_posts($args);

        return array_map(function ($report) {
            return [
                'title' => $report->post_title,
                'report_date' => get_post_meta($report->ID, self::META_PREFIX . 'report_date', true),
                'image_ids' => get_post_meta($report->ID, self::META_PREFIX . 'report_image'),
                'pdf_url' => get_post_meta($report->ID, self::META_PREFIX . 'pdf_url', true),
                'date_modified' => $report->post_modified,
                'permalink' => get_permalink($report->ID),
            ];
        }, $reports);
    }

    static function get_report(int $report_id): array
    {
        $report = get_post($report_id);

        return [
            'title' => $report->post_title,
            'report_date' => get_post_meta($report->ID, self::META_PREFIX . 'report_date', true),
            'image_ids' => get_post_meta($report->ID, self::META_PREFIX . 'report_image'),
            'pdf_url' => get_post_meta($report->ID, self::META_PREFIX . 'pdf_url', true),
            'date_modified' => $report->post_modified,
            'permalink' => get_permalink($report->ID),
        ];
    }
}