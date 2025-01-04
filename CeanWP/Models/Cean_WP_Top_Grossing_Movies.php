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
        self::$instance->setup_metabox();
        return self::$instance;

    }

    function setup_metabox()
    {
        // id, title, screen
        $meta_box = new MetaBox('movie_details', 'Movie Details', self::POST_TYPE);
        $meta_box->add_field(self::META_PREFIX . 'box_office', 'Box Office', 'number');
        $meta_box->add_field(self::META_PREFIX . 'movie_id', 'Movie ID', 'text');
        $meta_box->add_field(self::META_PREFIX . 'release_date', 'Release Date', 'date');
        $meta_box->add_field(self::META_PREFIX . 'image_url', 'Image URL', 'url');
        $meta_box->set_input_type_html('number', function ($id, $data) {
            $value = get_post_meta($id, $data['id'], true);
            echo "{$data['']}<input type='number' name='{$data['id']}' value='$value' />";
        });
        $this->register_metabox($meta_box);

    }

    /**
     * Register the custom post type
     */
    static function register_post_type() :  WP_Error|WP_Post_Type {
        $labels = array(
            'name'               => __('Top Grossing Movies', 'cean-wp-theme'),
            'singular_name'      => __('Movie', 'cean-wp-theme'),
            'add_new'            => __('Add New Movie', 'cean-wp-theme'),
            'add_new_item'       => __('Add New Movie', 'cean-wp-theme'),
            'edit_item'          => __('Edit Movie', 'cean-wp-theme'),
            'view_item'          => __('View Movie', 'cean-wp-theme'),
            'search_items'       => __('Search Movies', 'cean-wp-theme'),
            'not_found'          => __('No movies found', 'cean-wp-theme'),
        );

        $args = array(
            'labels'              => $labels,
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

        return register_post_type(self::POST_TYPE, $args);
    }


    /**
     * Get top grossing movies for a specific month and year
     */
    public static function get_top_grossing_movies($month, $year, $limit = 10): array {
        $args = array(
            'post_type'      => self::POST_TYPE,
            'posts_per_page' => $limit,
            'meta_key'       => self::META_PREFIX . 'box_office',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'meta_query'     => array(
                array(
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