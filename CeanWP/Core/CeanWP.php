<?php

namespace CeanWP\Core;

use CeanWP\Controllers\CEAN_Menu;
use CeanWP\Controllers\CountryHelper;
use CeanWP\Controllers\FrontendFormSubmission;
use CeanWP\Controllers\ReachCinemaAPI;
use CeanWP\Controllers\RewriteRules;
use CeanWP\Controllers\Settings;
use CeanWP\Models\Cean_WP_Movies;
use CeanWP\Models\CeanWP_BoxOffice;
use CeanWP\Models\CeanWP_Contact_Form;
use CeanWP\Models\CeanWP_FAQ;
use CeanWP\Types\Models;

class CeanWP
{

    const THEME_SUPPORTS = [
        'menus' => [self::class, 'cean_wp_menus'],
    ];

    private array $models = [];

    public function __construct()
    {
    }

    static function start(): void
    {
        $cean_wp_functions = new CeanWP();
        RewriteRules::turn_on();
        Settings::load();
        $cean_wp_functions->register_model(Cean_WP_Movies::get_instance());
        $cean_wp_functions->register_model(CeanWP_Contact_Form::get_instance());
        $cean_wp_functions->register_model(CeanWP_FAQ::get_instance());
        $cean_wp_functions->register_model(CeanWP_BoxOffice::get_instance());
        $cean_wp_functions->load();
    }

    function load(): void
    {
        add_action('wp_enqueue_scripts', array($this, 'cean_wp_enqueue_scripts'));
        add_action('after_setup_theme', array($this, 'cean_wp_theme_supports'));
        $this->setup_models();
        CEAN_Menu::init();
        FrontendFormSubmission::get_instance()
            ->add_form_from_model(
                CeanWP_Contact_Form::get_instance(),
                callback: [
                    CeanWP_Contact_Form::get_instance(),
                    'save_post_from_frontend'
                ])
            ->listen_to_form_submission();
    }

    function register_model(Models $model): void
    {
        if(!in_array($model, $this->models)){
            $this->models[] = $model;
        }
    }

    private function setup_models(): void
    {
        foreach ($this->models as $model) {
            $model->get_instance();
        }
    }

    function cean_wp_enqueue_scripts(): void
    {
        $ver = rand();

        wp_enqueue_script('cean-phone-country-dropdown', get_template_directory_uri() . '/assets/scripts/phone-country-dropdown.js', array('jquery'), $ver, true);
        wp_enqueue_script('cean-w3-js', get_template_directory_uri() . '/assets/libs/w3/w3.js', [], $ver, true);
        wp_enqueue_script('cean-swiper-js', get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.js', [], $ver, true);
        wp_enqueue_script('cean-slideshow', get_template_directory_uri() . '/assets/scripts/slideshow.js', array( 'jquery', 'cean-w3-js', 'cean-swiper-js'), $ver, true);


        wp_localize_script('cean-phone-country-dropdown', 'ceanPhoneCountryDropdown', [
            'countryCode' => CountryHelper::getAllCountriesPhoneCode(),
            'defaultCountryCode' => 'us'
        ]);

        wp_enqueue_style('cean-wp-tailwind', get_template_directory_uri() . '/assets/styles/tailwind.css', array(), $ver);
        wp_enqueue_style('cean-wp-flag-icon', get_template_directory_uri() . '/assets/libs/flag-icons/css/flag-icons.min.css', array(), $ver);
//        wp_enqueue_style('cean-swiper-css', get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.css', array(), $ver);
        wp_enqueue_style('cean-urbanist-font', get_template_directory_uri() . '/assets/fonts/urbanist/urbanist.css', array(), $ver);
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
                'title' => esc_html__('Filmhouse Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('The largest cinema chain in Nigeria, with 10 locations across the country.', 'cean-wp-theme'),
                'logo' => 'filmhouse',
            ],
            [
                'title' => esc_html__('Comscore', 'cean-wp-theme'),
                'description' => esc_html__('A global media measurement and analytics company, providing data and insights to the entertainment industry.', 'cean-wp-theme'),
                'logo' => 'comscore',
            ],
            [
                'title' => esc_html__('EbonyLife TV', 'cean-wp-theme'),
                'description' => esc_html__('A premium entertainment network, producing high-quality content for African audiences.', 'cean-wp-theme'),
                'logo' => 'ebonylife',
            ],
            [
                'title' => esc_html__('Silverbird Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A leading cinema chain in Nigeria, with 5 locations in Lagos and Abuja.', 'cean-wp-theme'),
                'logo' => 'silverbird',
            ],
            [
                'title' => esc_html__('Genesis Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A major cinema chain in Nigeria, with 9 locations across the country.', 'cean-wp-theme'),
                'logo' => 'genesis',
            ],
            [
                'title' => esc_html__('NFVCB', 'cean-wp-theme'),
                'description' => esc_html__('The National Film and Video Censors Board, responsible for regulating the film industry in Nigeria.', 'cean-wp-theme'),
                'logo' => 'nfvcb',
            ],
            [
                'title' => esc_html__('Ozone Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A popular cinema chain in Lagos, known for its state-of-the-art facilities and premium movie experience.', 'cean-wp-theme'),
                'logo' => 'ozone',
            ],
            [
                'title' => esc_html__('Nile Group', 'cean-wp-theme'),
                'description' => esc_html__('A leading film distribution company in Nigeria, with a focus on bringing quality international and local films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'nile-group',
            ],
            [
                'title' => esc_html__('Viva Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A modern cinema chain providing quality entertainment experiences across Nigeria.', 'cean-wp-theme'),
                'logo' => 'viva',
            ],
            [
                'title' => esc_html__('Kada Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A growing cinema chain delivering memorable movie experiences to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'kada',
            ],
            [
                'title' => esc_html__('Gren Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('An innovative cinema chain focused on providing premium entertainment services.', 'cean-wp-theme'),
                'logo' => 'grenhauz',
            ],
            [
                'title' => esc_html__('Havana Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A distinctive cinema brand offering unique movie-going experiences.', 'cean-wp-theme'),
                'logo' => 'havana',
            ],
            [
                'title' => esc_html__('Sanford Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A respected cinema chain known for its quality service and facilities.', 'cean-wp-theme'),
                'logo' => 'sandford',
            ],
            [
                'title' => esc_html__('Blue Pictures', 'cean-wp-theme'),
                'description' => esc_html__('A prominent entertainment company contributing to Nigeria\'s film industry growth.', 'cean-wp-theme'),
                'logo' => 'bluepicture',
            ],
            [
                'title' => esc_html__('Brands Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A cinema chain dedicated to delivering exceptional movie experiences.', 'cean-wp-theme'),
                'logo' => 'brands',
            ],
            [
                'title' => esc_html__('Capricon Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('An emerging cinema brand offering contemporary entertainment solutions.', 'cean-wp-theme'),
                'logo' => 'capricon',
            ],
            [
                'title' => esc_html__('Citadel Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A cinema chain committed to providing high-quality movie experiences.', 'cean-wp-theme'),
                'logo' => 'citadel',
            ],
            [
                'title' => esc_html__('Filmworld Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A dynamic cinema chain enhancing Nigeria\'s entertainment landscape.', 'cean-wp-theme'),
                'logo' => 'filmworld',
            ],
            [
                'title' => esc_html__('Grand Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A premier cinema destination offering memorable entertainment experiences.', 'cean-wp-theme'),
                'logo' => 'grand',
            ],
            [
                'title' => esc_html__('Habitat Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('An innovative cinema chain creating unique viewing experiences.', 'cean-wp-theme'),
                'logo' => 'habitat',
            ],
            [
                'title' => esc_html__('Heritage Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A cinema chain preserving and promoting film culture in Nigeria.', 'cean-wp-theme'),
                'logo' => 'heritage',
            ],
            [
                'title' => esc_html__('Hogis Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A modern cinema chain delivering quality entertainment services.', 'cean-wp-theme'),
                'logo' => 'hogis',
            ],
            [
                'title' => esc_html__('Magnificent Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A distinguished cinema brand known for exceptional viewing experiences.', 'cean-wp-theme'),
                'logo' => 'magnificent',
            ],
            [
                'title' => esc_html__('MCrystal Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A forward-thinking cinema chain expanding entertainment possibilities.', 'cean-wp-theme'),
                'logo' => 'mcrystal',
            ],
            [
                'title' => esc_html__('Mega Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A leading cinema chain providing diverse entertainment options.', 'cean-wp-theme'),
                'logo' => 'mega',
            ],
            [
                'title' => esc_html__('Mila Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('An emerging cinema brand focused on customer satisfaction.', 'cean-wp-theme'),
                'logo' => 'mila',
            ],
            [
                'title' => esc_html__('OOPL Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A contemporary cinema chain enriching Nigeria\'s entertainment sector.', 'cean-wp-theme'),
                'logo' => 'oopl',
            ],
            [
                'title' => esc_html__('Rainbow Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A vibrant cinema chain delivering diverse entertainment experiences.', 'cean-wp-theme'),
                'logo' => 'rainbow',
            ],
            [
                'title' => esc_html__('Timsed Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A progressive cinema chain committed to entertainment excellence.', 'cean-wp-theme'),
                'logo' => 'timsed',
            ],
            [
                'title' => esc_html__('Voicenel Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('An innovative cinema brand enhancing the movie-going experience.', 'cean-wp-theme'),
                'logo' => 'voicenel',
            ],
            [
                'title' => esc_html__('Zara Cinemas', 'cean-wp-theme'),
                'description' => esc_html__('A modern cinema chain providing premium entertainment services.', 'cean-wp-theme'),
                'logo' => 'zara',
            ],
        ];

        return apply_filters('cean_wp_partners_list', $partners);
    }
    /**
     * Get a list of distributors.
     *
     * @return array The distributors list.
     */
    static function get_distributors_list(): array
    {
        $distributors = [
            [
                'title' => esc_html__('Blue Pictures', 'cean-wp-theme'),
                'description' => esc_html__('A leading film distribution company in Nigeria, with a focus on bringing quality international and local films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'blue-pictures',
            ],
            [
                'title' => esc_html__('FilmOne Entertainment', 'cean-wp-theme'),
                'description' => esc_html__('A major film distribution company in Nigeria, with a track record of successful releases and collaborations with top filmmakers.', 'cean-wp-theme'),
                'logo' => 'filmone',
            ],
            [
                'title' => esc_html__('Genesis Distribution', 'cean-wp-theme'),
                'description' => esc_html__('A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'genesis-distribution',
            ],
            [
                'title' => esc_html__('Silverbird Film Distribution', 'cean-wp-theme'),
                'description' => esc_html__('A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'silverbird-distribution',
            ],
            [
                'title' => esc_html__('Nile Group', 'cean-wp-theme'),
                'description' => esc_html__('A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'nile-group',
            ],
            [
                'title' => esc_html__('Golden Effects Pictures', 'cean-wp-theme'),
                'description' => esc_html__('A film distribution company in Nigeria, with a focus on bringing quality films to Nigerian audiences.', 'cean-wp-theme'),
                'logo' => 'golden-effects',
            ],
            [
                'title' => esc_html__('Thc Cinemax', 'cean-wp-theme'),
                'description' => esc_html__('A film distribution company in Nigeria, known for its commitment to delivering high-quality movies to the Nigerian audience.', 'cean-wp-theme'),
                'logo' => 'thc-cinemax',
            ]
        ];

        return apply_filters('cean_wp_distributors_list', $distributors);
    }

    /**
     * Get the Board of Trustees list.
     *
     * @return array The Board of Trustees list.
     */
    static function get_board_of_trustees_list(): array
    {
        return [
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Silverbird Cinemas', 'cean-wp-theme'), 'logo' => 'silverbird'],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Genesis Cinemas', 'cean-wp-theme'), 'logo' => 'genesis'],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Viva Cinemas', 'cean-wp-theme'), 'logo' => 'viva'],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Ozone Cinemas', 'cean-wp-theme'), 'logo' => 'ozone'],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Filmhouse Cinemas', 'cean-wp-theme'), 'logo' => 'filmhouse'],
        ];
    }

    /**
     * Get the Esteemed Members list.
     *
     * @return array The Esteemed Members list.
     */
    static function get_esteemed_members_list(): array
    {
        return [
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Silverbird Cinemas', 'cean-wp-theme'),
                'logo' => 'silverbird',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Ozone Cinemas', 'cean-wp-theme'),
                'logo' => 'ozone',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Genesis Cinemas', 'cean-wp-theme'),
                'logo' => 'genesis',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Filmhouse Cinemas', 'cean-wp-theme'),
                'logo' => 'filmhouse',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Viva Cinemas', 'cean-wp-theme'),
                'logo' => 'viva',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Kada Cinemas', 'cean-wp-theme'),
                'logo' => 'kada',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Ebonylife Cinemas', 'cean-wp-theme'),
                'logo' => 'ebonylife',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Gren Cinemas', 'cean-wp-theme'),
                'logo' => 'grenhauz',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Havana Cinemas', 'cean-wp-theme'),
                'logo' => 'havana',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Sanford Cinemas', 'cean-wp-theme'),
                'logo' => 'sandford',
            ],
//            [
//                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
//                'name' => esc_html__('Imperial Cinemas', 'cean-wp-theme'),
//                'logo' => 'imperial',
//            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Blue Pictures', 'cean-wp-theme'),
                'logo' => 'bluepicture',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Brands Cinemas', 'cean-wp-theme'),
                'logo' => 'brands',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Capricon Cinemas', 'cean-wp-theme'),
                'logo' => 'capricon',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Citadel Cinemas', 'cean-wp-theme'),
                'logo' => 'citadel',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Filmworld Cinemas', 'cean-wp-theme'),
                'logo' => 'filmworld',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Grand Cinemas', 'cean-wp-theme'),
                'logo' => 'grand',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Habitat Cinemas', 'cean-wp-theme'),
                'logo' => 'habitat',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Heritage Cinemas', 'cean-wp-theme'),
                'logo' => 'heritage',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Hogis Cinemas', 'cean-wp-theme'),
                'logo' => 'hogis',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Magnificent Cinemas', 'cean-wp-theme'),
                'logo' => 'magnificent',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('MCrystal Cinemas', 'cean-wp-theme'),
                'logo' => 'mcrystal',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Mega Cinemas', 'cean-wp-theme'),
                'logo' => 'mega',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Mila Cinemas', 'cean-wp-theme'),
                'logo' => 'mila',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('OOPL Cinemas', 'cean-wp-theme'),
                'logo' => 'oopl',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Rainbow Cinemas', 'cean-wp-theme'),
                'logo' => 'rainbow',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Timsed Cinemas', 'cean-wp-theme'),
                'logo' => 'timsed',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Voicenel Cinemas', 'cean-wp-theme'),
                'logo' => 'voicenel',
            ],
            [
                'since' => esc_html__('Since 2019', 'cean-wp-theme'),
                'name' => esc_html__('Zara Cinemas', 'cean-wp-theme'),
                'logo' => 'zara',
            ],
        ];
    }

    /**
     * Get the Team Members list.
     *
     * @return array The team members list.
     */
    static function get_team_members_list(): array
    {
        $team_members = [
            [
                'name' => esc_html__('Ope Ajayi', 'cean-wp-theme'),
                'img' => 'ope-ajayi.jpg',
                'title' => esc_html__('Chairman', 'cean-wp-theme'),
                'description' => esc_html__('Ope Ajayi is the founder and CEO of Cinemax Distribution Limited, a company that provides integrated services across the various film sub-sectors, including production, distribution, and exhibition. He is a film producer and distributor with a passion for creating and delivering quality content that entertains, educates, and inspires audiences.', 'cean-wp-theme'),
                'socials' => [
                    'linkedin' => 'https://www.linkedin.com/in/ope-ajayi-6b542a21/',
                ]
            ],
            [
                'name' => esc_html__('Moses Babatope', 'cean-wp-theme'),
                'img' => 'moses-babatope.jpg',
                'title' => esc_html__('Secretary', 'cean-wp-theme'),
                'description' => esc_html__('Moses Babatope is a leading figure in the Nigerian and African film industry with over 20 years of experience. He is the Group CEO of Nile Media Entertainment Group and co-founder of FilmHouse Group and Talking Drum Entertainment Limited. He has significantly transformed Nollywood and elevated African films globally.', 'cean-wp-theme'),
                'socials' => [
                    'linkedin' => 'https://www.linkedin.com/in/moses-babatope-9ba014134/',
                ]
            ],
            [
                'name' => esc_html__('Jonathan Yakubu', 'cean-wp-theme'),
                'img' => 'jonathan-yakubu.jpg',
                'title' => esc_html__('Treasurer', 'cean-wp-theme'),
                'description' => esc_html__('Jonathan Yakubu is a dynamic senior financial accounting professional with progressive experience in auditing, finance, tax consulting, relationship management, and business development. He is adept at directing complex projects and collaborating with high-performance teams to enhance operations.', 'cean-wp-theme'),
                'socials' => [
                    'linkedin' => 'https://www.linkedin.com/in/jonathan-yakubu-fca-fcti-acma-cgma-mba-msc-7122833a/',
                ]
            ],
            [
                'name' => esc_html__('Shileola Ibironke', 'cean-wp-theme'),
                'img' => 'shileola-ibironke.jpg',
                'title' => esc_html__('Media and Publicity', 'cean-wp-theme'),
                'description' => esc_html__('Shileola Ibironke is the MD/CEO of Micromedia Group of Companies, owner of Nigeria’s foremost broadcast content production and distribution company. With over 17 years of experience, she is a result-driven executive dedicated to maximizing organizational efficiency and development.', 'cean-wp-theme'),
                'socials' => [
                    'linkedin' => 'https://www.linkedin.com/in/shileola-ibironke-b7a105121/',
                ]
            ],
            [
                'name' => esc_html__('Patrick Lee', 'cean-wp-theme'),
                'img' => 'patrick-lee.jpg',
                'title' => esc_html__('Exco Member', 'cean-wp-theme'),
                'description' => esc_html__('Patrick Lee is a conscientious and professional executive with extensive experience in the Nigerian Cinema Industry. He was instrumental in the implementation of Ozone Cinemas and the introduction of the cinema reporting system, Comscore, while serving as Chairman of the Cinema Exhibitors Association of Nigeria.', 'cean-wp-theme'),
                'socials' => [
                    'linkedin' => 'https://www.linkedin.com/in/patrick-lee-8a9b68189/',
                ]
            ]
        ];

        return apply_filters('cean_wp_team_members_list', $team_members);
    }


    static function get_contact_socials() : array {
        $socials = [
            [
                'title' => 'Twitter',
                'url' => 'https://x.com/FusionIntelTech/',
                'icon' => 'twitter',
            ],
            [
                'title' => 'Instagram',
                'url' => 'https://www.instagram.com/fusionintelligence/',
                'icon' => 'instagram',
            ],
            [
                'title' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/company/fusion-intelligence-technologies/',
                'icon' => 'linkedin',
            ],
        ];
        return apply_filters('cean_wp_contact_socials', $socials);
    }


    /**
     * Get the common social media icons used in the theme.
 *
     * @return array The common social media icons.
     */
    static function common_social_icons(): array
    {
        return [
            'instagram' => '/images/icons/socials/instagram.svg',
            'twitter' => '/images/icons/socials/twitter.svg',
            'linkedin' => '/images/icons/socials/linkedin.svg',
            'medium' => '/images/icons/socials/medium.svg',
        ];

    }

    /**
     * Get the common icons used in the theme.
     *
     * @return array The common icons.
     */
    static function common_icons(): array
    {
        return array_merge(
            self::common_social_icons(),
            [
                'cean-logo' => '/images/cean-logo.png',  // assets icon
                'arrow-tr' => '/images/icons/arrow-tr.png',
                'external-link' => '/images/icons/arrow-tr.png',
                'white-left-arrow' => '/images/icons/arrow-l-w.svg',
                'white-right-arrow' => '/images/icons/arrow-r-w.svg',
                'menu-icon' => '/images/icons/menu-icon.svg',
                'clipboard' => '/images/icons/clipboard.png',
                'emergency-lamp' => '/images/icons/emergency-lamp.png',
                'puzzle' => '/images/icons/puzzle.png',
                'bag' => '/images/icons/bag.png',
                'est-meb' => '/images/icons/est-meb.png',

                // Add the logos for partners and distributors here
                'filmhouse' => '/images/partners/filmhouse.png',
                'comscore' => '/images/partners/comscore.png',
                'ebonylife' => '/images/partners/black-white/ebonylife.png', // Updated to black-white
                'silverbird' => '/images/partners/silverbird.png',
                'genesis' => '/images/partners/genesis.png',
                'nfvcb' => '/images/partners/nfvcb.png',
                'ozone' => '/images/partners/ozone.png',
                'blue-pictures' => '/images/distributors/blue-pictures.png',
                'filmone' => '/images/distributors/filmone.png',
                'genesis-distribution' => '/images/distributors/genesis.png',
                'silverbird-distribution' => '/images/distributors/silverbird.png',
                'nile-group' => '/images/distributors/nile-group.png',
                'golden-effects' => '/images/distributors/golden-effects.png',
                'thc-cinemax' => '/images/distributors/thc.png',

                // New logos from partners directory
                'imperial' => '/images/partners/Imperial.jpeg',
                'elc' => '/images/partners/elc.png',
                'gren' => '/images/partners/gren-logo.webp',
                'havana' => '/images/partners/havana.png',
                'kada' => '/images/partners/black-white/kada.png', // Updated to black-white
                'nova' => '/images/partners/nova-logo.webp',
                'sky-cinema' => '/images/partners/sky-cenima.svg',
                'viva' => '/images/partners/black-white/viva.png', // Updated to black-white
                'wosam' => '/images/partners/wosam.png',

                // Adding new black-white partner icons
                'ebonylife' => '/images/partners/black-white/ebonylife.png',
                'bluepicture' => '/images/partners/black-white/bluepicture.png',
                'brands' => '/images/partners/black-white/brands.png',
                'capricon' => '/images/partners/black-white/capricon.png',
                'citadel' => '/images/partners/black-white/citadel.png',
                'filmworld' => '/images/partners/black-white/filmworld.png',
                'grand' => '/images/partners/black-white/grand.png',
                'grenhauz' => '/images/partners/black-white/grenhauz.png', // Already in black-white section
                'habitat' => '/images/partners/black-white/habitat.png',
                'heritage' => '/images/partners/black-white/heritage.png',
                'hogis' => '/images/partners/black-white/hogis.png',
                'magnificent' => '/images/partners/black-white/magnificent.png',
                'mcrystal' => '/images/partners/black-white/mcrystal.png',
                'mega' => '/images/partners/black-white/mega.png',
                'mila' => '/images/partners/black-white/mila.png',
                'oopl' => '/images/partners/black-white/oopl.png',
                'rainbow' => '/images/partners/black-white/rainbow.png',
                'timsed' => '/images/partners/black-white/timsed.png',
                'voicenel' => '/images/partners/black-white/voicenel.png',
                'zara' => '/images/partners/black-white/zara.png',
                'sandford' => '/images/partners/black-white/sandford.png',
            ]
        );
    }
    /**
     * Get the URL of a common icon used in the theme.
     *
     * @param string $key The key of the icon to retrieve.
     *
     * @return string The URL of the icon.
     */
    static function get_common_icon_url(string $key) : string
    {
        $icons = self::common_icons();
        if (isset($icons[$key])) {
            if (filter_var($icons[$key], FILTER_VALIDATE_URL)) {
                return $icons[$key];
            } else {
                return get_theme_file_uri('assets' . $icons[$key]);
            }
        }
        return '';
    }


    static function get_all_time_top_grossing_movies($by = 'all_time', $limit = 10): array
    {
        // getting all time grossing movies
        return Cean_WP_Movies::get_top_grossing_movies($by, $limit);
    }


    static function get_inquiry_type() : array
    {
        return CeanWP_Contact_Form::INQUIRY_TYPES;
    }

    static function get_heard_about_us() : array
    {
        return CeanWP_Contact_Form::HEARD_ABOUT_US;
    }

    static function get_faqs($count = -1): array
    {
        return CeanWP_FAQ::get_faqs($count);
    }


    static function get_reports(): array
    {
        return CeanWP_BoxOffice::get_reports();
    }

    static function get_report(int $id): array
    {
        return CeanWP_BoxOffice::get_report($id);
    }

    static function get_movie(int $id): array
    {
        return Cean_WP_Movies::get_movie($id);
    }

    static function get_coming_soon_from_reach(): array
    {
        return ReachCinemaAPI::get_coming_soon_movies();
    }

    static function get_movie_details_from_reach($film_id): ?array
    {
        $movie_data = ReachCinemaAPI::get_movie($film_id);
        if (!isset($movie_data['data'])) {
            return null;
        }
        $movie_data = $movie_data['data'];
        return Cean_WP_Movies::map_reach_movie_data_to_cean_usable($movie_data);
    }

    static function get_best_slide_show_content($limit = 5) : array {
        $best = [];
        try {
            $best = ReachCinemaAPI::get_coming_soon_movies();
            if (isset($best['data'])) {
                $best = $best['data'];
                $best = array_map(function ($movie) {
                    return Cean_WP_Movies::map_reach_movie_data_to_cean_usable($movie);
                }, $best);
                return $best;
            }
            else {
                $best = Cean_WP_Movies::get_top_grossing_movies();
            }
        } catch (\Exception $e) {
            $best = Cean_WP_Movies::get_top_grossing_movies();
        }
        finally {
            return array_slice($best, 0, $limit);
        }
    }


    static function get_hero_wallpaper() : string
    {
        $url = Settings::get('hero_wall_paper');
        return empty($url) ? get_theme_file_uri('assets/images/index-hero-image.png') : $url;
    }

    static  function formatBoxOffice($number): string
    {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 1) . 'B'; // Billions
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M'; // Millions
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'k'; // Thousands
        }
        return number_format($number); // Less than 1k
    }
}

