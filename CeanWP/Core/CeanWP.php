<?php

namespace CeanWP\Core;

use CeanWP\Controllers\CEAN_Menu;
use CeanWP\Controllers\CountryHelper;
use CeanWP\Controllers\FrontendFormSubmission;
use CeanWP\Models\Cean_WP_Top_Grossing_Movies;
use CeanWP\Models\CeanWP_Contact_Form;
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
        $cean_wp_functions->register_model(Cean_WP_Top_Grossing_Movies::init());
        $cean_wp_functions->register_model(CeanWP_Contact_Form::init());
        $cean_wp_functions->load();
    }

    function load(): void
    {
        add_action('wp_enqueue_scripts', array($this, 'cean_wp_enqueue_scripts'));
        add_action('after_setup_theme', array($this, 'cean_wp_theme_supports'));
        $this->setup_models();
        CEAN_Menu::init();
        FrontendFormSubmission::get_instance()->add_form_from_model(CeanWP_Contact_Form::init(), callback: [CeanWP_Contact_Form::init(), 'save_post_from_frontend'])->listen_to_form_submission();
    }

    function register_model(Models $model): void
    {
        $this->models[] = $model;
    }

    private function setup_models(): void
    {
        foreach ($this->models as $model) {
            $model->init();
        }
    }

    function cean_wp_enqueue_scripts(): void
    {
        $ver = rand();

        wp_enqueue_script('cean-phone-country-dropdown', get_template_directory_uri() . '/assets/scripts/phone-country-dropdown.js', array('jquery'), $ver, true);
        wp_localize_script('cean-phone-country-dropdown', 'ceanPhoneCountryDropdown', [
            'countryCode' => CountryHelper::getAllCountriesPhoneCode(),
            'defaultCountryCode' => 'us'
        ]);

        wp_enqueue_style('cean-wp-tailwind', get_template_directory_uri() . '/assets/styles/tailwind.css', array(), $ver);
        wp_enqueue_style('cean-wp-flag-icon', get_template_directory_uri() . '/assets/libs/flag-icons/css/flag-icons.min.css', array(), $ver);
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
            ]
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
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Silverbird Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Genesis Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Viva Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Ozone Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Filmhouse Cinemas', 'cean-wp-theme')],
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
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Silverbird Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Ozone Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Genesis Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Filmhouse Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Viva Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Kada Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Mees Palace Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Cartege Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Lighthouse Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Grand Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Maturion Cinemas', 'cean-wp-theme')],
            ['since' => esc_html__('Since 2019', 'cean-wp-theme'), 'name' => esc_html__('Cartege Cinemas', 'cean-wp-theme')],
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
                'name' => esc_html__('Patrick Lee', 'cean-wp-theme'),
                'title' => esc_html__('Chairman', 'cean-wp-theme'),
                'description' => esc_html__('Patrick is a conscientious and professional Executive with extensive experience in the Nigerian Cinema Industry.', 'cean-wp-theme'),
                'socials' => [
                    'instagram' => 'https://www.instagram.com',
                    'twitter' => 'https://www.twitter.com',
                    'linkedin' => 'https://www.linkedin.com',
                ]
            ],
            [
                'name' => esc_html__('Moses Babatope', 'cean-wp-theme'),
                'title' => esc_html__('Secretary', 'cean-wp-theme'),
                'description' => esc_html__('Moses is passionate about taking Nigerian films across the globe, accessing new markets and delivering returns to stakeholders.', 'cean-wp-theme'),
                'socials' => [
                    'instagram' => 'https://www.instagram.com',
                    'twitter' => 'https://www.twitter.com',
                    'linkedin' => 'https://www.linkedin.com',
                ]
            ],
            [
                'name' => esc_html__('Opeyemi Agayi', 'cean-wp-theme'),
                'title' => esc_html__('Treasurer', 'cean-wp-theme'),
                'description' => esc_html__('Opeyemi has over 15 years of combined business management, entertainment, advisory, and entrepreneurship experience.', 'cean-wp-theme'),
                'socials' => [
                    'instagram' => 'https://www.instagram.com',
                    'twitter' => 'https://www.twitter.com',
                    'linkedin' => 'https://www.linkedin.com',
                ]
            ],
            [
                'name' => esc_html__('Michael Ndiomu', 'cean-wp-theme'),
                'title' => esc_html__('Exco', 'cean-wp-theme'),
                'description' => esc_html__('Michael is a financial services expert with experience in several banks including UBA and Access Bank Plc.', 'cean-wp-theme'),
                'socials' => [
                    'instagram' => 'https://www.instagram.com',
                    'twitter' => 'https://www.twitter.com',
                    'linkedin' => 'https://www.linkedin.com',
                ]
            ]
        ];

        return apply_filters('cean_wp_team_members_list', $team_members);
    }

    static function get_contact_socials() : array {
        $socials = [
            [
                'title' => 'Twitter',
                'url' => 'https://twitter.com/ceanigeria',
                'icon' => 'twitter',
            ],
            [
                'title' => 'Medium',
                'url' => 'https://medium.com/ceanigeria',
                'icon' => 'medium',
            ],
            [
                'title' => 'LinkedIn',
                'url' => 'https://linkedin.com/ceanigeria',
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

    static function common_icons()
    {
        return array_merge(
            self::common_social_icons(),
            [
                'cean-logo' => '/images/cean-logo.png',

//                assets icon
                'arrow-tr' => '/images/icons/arrow-tr.png',
                'external-link' => '/images/icons/arrow-tr.png',

                // Add the logos for partners and distributors here
                'filmhouse' => '/images/partners/filmhouse.png',
                'comscore' => '/images/partners/comscore.png',
                'ebonylife' => '/images/partners/ebonylife.png',
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

}

