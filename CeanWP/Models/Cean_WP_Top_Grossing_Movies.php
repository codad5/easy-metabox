<?php

namespace CeanWP\Models;

use CeanWP\Libs\MetaBox;
use CeanWP\Types\Models;
use WP_Error;
use WP_Post_Type;
use WP_Query;
use CeanWP\Traits\Models as ModelsTrait;

class Cean_WP_Top_Grossing_Movies implements Models
{
    use ModelsTrait;
    const POST_TYPE = 'top_grossing_movie';
    const META_PREFIX = '_cean_movie_';
    static Cean_WP_Top_Grossing_Movies $instance;

    static function init(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        // Register post type and meta boxes
        add_action('init', [self::$instance, 'register_post_type']);
        add_action('save_post', [self::$instance, 'save_post']);

        add_filter('manage_' . self::POST_TYPE . '_posts_columns', [self::$instance, 'set_custom_columns']);
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', [self::$instance, 'custom_column_content'], 10, 2);
        add_filter('manage_edit-' . self::POST_TYPE . '_sortable_columns', [self::$instance, 'set_sortable_columns']);

        // Add hook for sorting functionality
        add_action('pre_get_posts', [self::$instance, 'sort_columns']);

        self::$instance->setup_metabox();
        return self::$instance;

    }

    /**
     * Define custom columns for the admin table
     *
     * @param array $columns Existing columns
     * @return array Modified columns
     */
    function set_custom_columns(array $columns): array {
        $new_columns = array();

        // Move checkbox and title to the start if they exist
        if (isset($columns['cb'])) {
            $new_columns['cb'] = $columns['cb'];
        }
        if (isset($columns['title'])) {
            $new_columns['title'] = $columns['title'];
        }

        // Add our custom columns
        $new_columns['box_office'] = __('Box Office', 'cean-wp-theme');
        $new_columns['release_date'] = __('Release Date', 'cean-wp-theme');

        return $new_columns;
    }

    /**
     * Add content to custom columns
     *
     * @param string $column Column identifier
     * @param int $post_id Post ID
     * @return void
     */
    function custom_column_content(string $column, int $post_id): void {
        switch ($column) {
            case 'box_office':
                $box_office = get_post_meta($post_id, self::META_PREFIX . 'box_office', true);
                if ($box_office) {
                    // Format the number with commas and dollar sign
                    echo '₦' . number_format($box_office, 0, '.', ',');
                }
                break;

            case 'release_date':
                $release_date = get_post_meta($post_id, self::META_PREFIX . 'release_date', true);
                if ($release_date) {
                    // Format the date
                    echo date('F j, Y', strtotime($release_date));
                }
                break;
        }
    }

    /**
     * Make custom columns sortable
     */
    function set_sortable_columns($columns): array {
        $columns['box_office'] = self::META_PREFIX . 'box_office';
        $columns['release_date'] = self::META_PREFIX . 'release_date';
        return $columns;
    }

    /**
     * Handle the custom sorting
     */
    function sort_columns($query) {
        if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== self::POST_TYPE) {
            return;
        }

        $orderby = $query->get('orderby');

        switch ($orderby) {
            case self::META_PREFIX . 'box_office':
                $query->set('meta_key', self::META_PREFIX . 'box_office');
                $query->set('orderby', 'meta_value_num');
                break;

            case self::META_PREFIX . 'release_date':
                $query->set('meta_key', self::META_PREFIX . 'release_date');
                $query->set('orderby', 'meta_value');
                break;
        }
    }



    function setup_metabox()
    {
        // id, title, screen
        $meta_box = new MetaBox('movie_details', 'Movie Details', self::POST_TYPE);
        $meta_box->add_field(self::META_PREFIX . 'box_office', 'Box Office', 'number');
        $meta_box->add_field(self::META_PREFIX . 'movie_id', 'Movie ID', 'text');
        $meta_box->add_field(self::META_PREFIX . 'release_date', 'Release Date', 'date');
        $meta_box->add_field(self::META_PREFIX . 'image_url', 'Image URL', 'url');
        $this->register_metabox($meta_box);

    }

    static function get_post_type_args(): array
    {
        return array(
            'labels'              => array(
                'name'               => __('Top Grossing Movies', 'cean-wp-theme'),
                'singular_name'      => __('Movie', 'cean-wp-theme'),
                'add_new'            => __('Add New Movie', 'cean-wp-theme'),
                'add_new_item'       => __('Add New Movie', 'cean-wp-theme'),
                'edit_item'          => __('Edit Movie', 'cean-wp-theme'),
                'view_item'          => __('View Movie', 'cean-wp-theme'),
                'search_items'       => __('Search Movies', 'cean-wp-theme'),
                'not_found'          => __('No movies found', 'cean-wp-theme'),
            ),
            'public'              => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-video-alt2',
            'supports'            => array('title', 'thumbnail'),
            'has_archive'         => true,
            'rewrite'             => array('slug' => 'movies'),
            'show_in_rest'        => true, // Enable Gutenberg editor
            'publicly_queryable'  => true,
        );
    }

    /**
     * Get top grossing movies for a specific month and year
     */
    public static function get_top_grossing_movies($year = null, $month = null,  $limit = 10): array {
        $args = array(
            'post_type'      => self::POST_TYPE,
            'posts_per_page' => $limit,
            'meta_key'       => self::META_PREFIX . 'box_office',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'meta_query'     => array(
                $year === null ? [] : array(
                    'key'     => self::META_PREFIX . 'release_date',
                    'value'   => array("$year-$month-01", "$year-$month-31"),
                    'type'    => 'DATE',
                    'compare' => 'BETWEEN'
                )
            )
        );

        $query = new WP_Query($args);
        $movies = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $movies[] = array(
                    'title'      => get_the_title(),
                    'box_office' => get_post_meta(get_the_ID(), self::META_PREFIX . 'box_office', true),
                    'movie_id'   => get_post_meta(get_the_ID(), self::META_PREFIX . 'movie_id', true),
                    'image_url'  => get_the_post_thumbnail_url(get_the_ID(), 'full')
                );
            }
            wp_reset_postdata();
        }

        return $movies;
    }
}