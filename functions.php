<?php

/**
 * Enqueue scripts and styles.
 */


class Cean_WP_Functions {

    const array THEME_SUPPORTS = [
        'menus' => [self::class, 'cean_wp_menus'],
    ];

    public function __construct() {
    }

    static function start(): void
    {
        $cean_wp_functions = new Cean_WP_Functions();
        $cean_wp_functions->load();
    }

    function load(): void
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'cean_wp_enqueue_scripts' ) );
        add_action( 'after_setup_theme', array( $this, 'cean_wp_theme_supports' ) );
    }

    function cean_wp_enqueue_scripts(): void
    {
        $ver = rand();
        wp_enqueue_style( 'cean-wp-tailwind', get_template_directory_uri() . '/assets/styles/tailwind.css', array(), $ver );
    }

    function cean_wp_theme_supports(): void
    {
        foreach (self::THEME_SUPPORTS as $feature => $callback) {
            add_theme_support($feature);
            if (is_callable($callback)) {
                call_user_func($callback);
            }
        }
    }

    static function cean_wp_menus(): void
    {
        register_nav_menus(
            array(
                'top-menu' => __( 'Top Menu' , 'cean-wp-theme'),
                'useful-links' => __( 'Useful Links' , 'cean-wp-theme'),
                'services' => __( 'Services' , 'cean-wp-theme'),
                'support' => __( 'Support' , 'cean-wp-theme'),
                'careers' => __( 'Careers' , 'cean-wp-theme'),
                'terms-privacy' => __( 'Terms & Privacy' , 'cean-wp-theme'),
            )
        );
    }

}

Cean_WP_Functions::start();
