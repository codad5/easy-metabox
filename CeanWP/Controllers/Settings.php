<?php
namespace CeanWP\Controllers;

class Settings {
    const OPTION_PREFIX = 'ceanwp_';
    const SETTINGS = [
        [
            'option_name' => 'reach_api_key',
            'label' => 'Reach API key',
            'type' => 'text',
            'default' => '',
            'placeholder' => 'Your Reach API key',
            'description' => 'Enter your Reach API key here',
            'tab' => 'api',
        ],
//        setting for GitHub personal access token to enable auto updates
        [
            'option_name' => 'github_personal_access_token',
            'label' => 'GitHub Personal Access Token',
            'type' => 'text',
            'default' => '',
            'placeholder' => 'Your GitHub Personal Access Token',
            'description' => 'Enter your GitHub Personal Access Token here',
            'tab' => 'api',
        ],
        [
            'option_name' => 'hero_wall_paper',
            'label' => 'Hero Wall Paper',
            'type' => 'url',
            'default' => '',
            'placeholder' => 'URL to the hero wall paper',
            'description' => 'Enter the URL to the hero wall paper here',
            'tab' => 'api',
        ],
    ];

    static function load() {
        add_action('admin_init', [self::class, 'register_settings']);
    }

    static function register_settings(): void {
        // Register the settings
        foreach (self::SETTINGS as $setting) {
            register_setting(
                self::OPTION_PREFIX . $setting['tab'],
                self::OPTION_PREFIX . $setting['option_name'],
                [
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                    'default' => $setting['default'],
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            );
        }

        // Add API Settings Section
        add_settings_section(
            'ceanwp_api_section',
            'API Settings',
            [self::class, 'api_section_callback'],
            'ceanwp_settings'
        );

        // Add settings fields
        foreach (self::SETTINGS as $setting) {
            add_settings_field(
                self::OPTION_PREFIX . $setting['option_name'],
                $setting['label'],
                [self::class, 'render_field'],
                'ceanwp_settings',
                'ceanwp_api_section',
                [
                    'label_for' => self::OPTION_PREFIX . $setting['option_name'],
                    'setting' => $setting
                ]
            );
        }
    }

    static function api_section_callback($args): void {
        echo '<p>Configure your API settings below:</p>';
    }

    static function render_field($args): void {
        $setting = $args['setting'];
        $option_name = self::OPTION_PREFIX . $setting['option_name'];
        $value = self::get($setting['option_name']);

        switch ($setting['type']) {
            case 'text':
                printf(
                    '<input type="text" id="%s" name="%s" value="%s" placeholder="%s" class="regular-text">',
                    esc_attr($option_name),
                    esc_attr($option_name),
                    esc_attr($value),
                    esc_attr($setting['placeholder'])
                );
                break;

            case 'url':
                printf(
                    '<input type="url" id="%s" name="%s" value="%s" placeholder="%s" class="regular-text">',
                    esc_attr($option_name),
                    esc_attr($option_name),
                    esc_attr($value),
                    esc_attr($setting['placeholder'])
                );
                break;

            default:
                // Render an input with the specified type
                printf(
                    '<input type="%s" id="%s" name="%s" value="%s" placeholder="%s" class="regular-text">',
                    esc_attr($setting['type']), // Use the type from the settings array
                    esc_attr($option_name),
                    esc_attr($option_name),
                    esc_attr($value),
                    esc_attr($setting['placeholder'])
                );
                break;
        }

        if (!empty($setting['description'])) {
            printf('<p class="description">%s</p>', esc_html($setting['description']));
        }
    }


    static function setting_page(): void {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('CeanWP Settings', 'cean-wp-theme'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields(self::OPTION_PREFIX . 'api');
                do_settings_sections('ceanwp_settings');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    static function store($key, $value): bool {
        $value = sanitize_text_field($value);
        return update_option(self::OPTION_PREFIX . $key, $value);
    }

    static function get($key, $default = ''): string {
        return get_option(self::OPTION_PREFIX . $key, $default);
    }
}