<?php

namespace CeanWP\Core;

use CeanWP\Controllers\CEAN_Menu;
use CeanWP\Models\Cean_WP_Top_Grossing_Movies;

class CeanWP
{

    const THEME_SUPPORTS = [
        'menus' => [self::class, 'cean_wp_menus'],
    ];

    public function __construct()
    {
    }

    static function start(): void
    {
        $cean_wp_functions = new CeanWP();
        $cean_wp_functions->load();
    }

    function load(): void
    {
        add_action('wp_enqueue_scripts', array($this, 'cean_wp_enqueue_scripts'));
        add_action('after_setup_theme', array($this, 'cean_wp_theme_supports'));
        (new \CeanWP\Models\Cean_WP_Top_Grossing_Movies)->init();
        CEAN_Menu::init();
    }

    function cean_wp_enqueue_scripts(): void
    {
        $ver = rand();
        wp_enqueue_style('cean-wp-tailwind', get_template_directory_uri() . '/assets/styles/tailwind.css', array(), $ver);
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
                'top-menu' => __('Top Menu', 'cean-wp-theme'),
                'useful-links' => __('Useful Links', 'cean-wp-theme'),
                'services' => __('Services', 'cean-wp-theme'),
                'support' => __('Support', 'cean-wp-theme'),
                'careers' => __('Careers', 'cean-wp-theme'),
                'terms-privacy' => __('Terms & Privacy', 'cean-wp-theme'),
            )
        );
    }

    /**
     * Get a list of partners.
     *
     * @return array The partners list.
     */
    static function get_partners_list(): array
    {
        $partners = [
            [
                'title' => 'Filmhouse Cinemas',
                'description' => 'The largest cinema chain in Nigeria, with 10 locations across the country.',
                'logo' => 'filmhouse.png'
            ],
            [
                'title' => 'Comscore',
                'description' => 'A global media measurement and analytics company, providing data and insights to the entertainment industry.',
                'logo' => 'comscore.png'
            ],
            [
                'title' => 'EbonyLife TV',
                'description' => 'A premium entertainment network, producing high-quality content for African audiences.',
                'logo' => 'ebonylife.png'
            ],
            [
                'title' => 'Silverbird Cinemas',
                'description' => 'A leading cinema chain in Nigeria, with 5 locations in Lagos and Abuja.',
                'logo' => 'silverbird.png'
            ],
            [
                'title' => 'Genesis Cinemas',
                'description' => 'A major cinema chain in Nigeria, with 9 locations across the country.',
                'logo' => 'genesis.png'
            ],
            [
                'title' => 'NFVCB',
                'description' => 'The National Film and Video Censors Board, responsible for regulating the film industry in Nigeria.',
                'logo' => 'nfvcb.png'
            ],
            [
                'title' => 'Ozone Cinemas',
                'description' => 'A popular cinema chain in Lagos, known for its state-of-the-art facilities and premium movie experience.',
                'logo' => 'ozone.png'
            ]
        ];

        // Allow customization via a filter
        return apply_filters('cean_wp_partners_list', $partners);
    }

    /**
     * Get a list of distributors.
     *
     * @return array The distributors list.
     */
    static function get_distributors_list(): array
    {
        // blue picture , filmone, genesis, silverbird, nile-group,  golden
        $distributors = [
            [
                'title' => 'Blue Pictures',
                'description' => 'A leading film distribution company in Nigeria, with a focus on bringing quality international and local films to Nigerian audiences.',
                'logo' => 'blue-pictures.png'
            ],
            [
                'title' => 'FilmOne Entertainment',
                'description' => 'A major film distribution company in Nigeria, with a track record of successful releases and collaborations with top filmmakers.',
                'logo' => 'filmone.png'
            ],
            [
                'title' => 'Genesis Distribution',
                'description' => 'A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.',
                'logo' => 'genesis.png'
            ],
            [
                'title' => 'Silverbird Film Distribution',
                'description' => 'A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.',
                'logo' => 'silverbird.png'
            ],
            [
                'title' => 'Nile Group',
                'description' => 'A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.',
                'logo' => 'nile-group.png'
            ],
            [
                'title' => 'Golden Effects Pictures',
                'description' => 'A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.',
                'logo' => 'golden-effects.png'
            ]
        ];

        return apply_filters('cean_wp_distributors_list', $distributors);
    }
}

CeanWP::start();
