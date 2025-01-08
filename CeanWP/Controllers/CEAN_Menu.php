<?php
namespace CeanWP\Controllers;

/**
 * Class CEAN_Menu
 *
 * Handles the creation and management of admin menus and submenus
 * for the CEAN theme.
 *
 * @package CeanWP\Controllers
 */
class CEAN_Menu {
    /**
     * Main menu slug
     */
    const MENU_SLUG = 'cean-theme-settings';

    /**
     * Returns an array of menus to be added to the admin menu.
     *
     * @return array The array of menus.
     */
    static function menus(): array {
        return [
            self::MENU_SLUG => [
                'title' => esc_html__('CEAN Theme', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'icon' => 'dashicons-admin-appearance',
                'position' => '2',
                'callback' => 'render_main_page'
            ],
        ];
    }

    /**
     * Returns an array of submenus to be added to the admin menu.
     *
     * @return array The array of submenus.
     */
    static function submenus(): array {
        return [
            'edit.php?post_type=top_grossing_movie' => [
                'parent' => self::MENU_SLUG,
                'title' => esc_html__('Top Grossing Movies', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'callback' => false
            ],
            'edit.php?post_type=cean_contact_form' => [
                'parent' => self::MENU_SLUG,
                'title' => esc_html__('Form Submissions', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'callback' => false
            ],
            'edit.php?post_type=cean_faq' => [
                'parent' => self::MENU_SLUG,
                'title' => esc_html__('FAQs', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'callback' => false
            ],
            'edit.php?post_type=cean_box_office' => [
                'parent' => self::MENU_SLUG,
                'title' => esc_html__('Box Office Reports', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'callback' => false
            ],

            'cean-theme-settings' => [
                'parent' => self::MENU_SLUG,
                'title' => esc_html__('Theme Settings', 'cean-wp-theme'),
                'capability' => 'manage_options',
                'callback' => 'render_settings_page'
            ],

            // Add more submenus as needed
        ];
    }

    /**
     * Retrieves a specific menu by its ID.
     *
     * @param string $id The menu ID.
     * @return array|null The menu array or null if not found.
     */
    static function get_menu(string $id): ?array {
        $menus = self::menus();
        return $menus[$id] ?? null;
    }

    /**
     * Retrieves a specific submenu by its ID.
     *
     * @param string $id The submenu ID.
     * @return array|null The submenu array or null if not found.
     */
    static function get_submenu(string $id): ?array {
        $submenus = self::submenus();
        return $submenus[$id] ?? null;
    }

    /**
     * Initialize the menu system.
     */
    static function init(): void {
        add_action('admin_menu', [self::class, 'register_menus']);
    }

    /**
     * Register all menus and submenus.
     */
    static function register_menus(): void {
        // Register main menus
        foreach (self::menus() as $menu_slug => $menu) {
            add_menu_page(
                $menu['title'],
                $menu['title'],
                $menu['capability'],
                $menu_slug,
                self::get_callback($menu['callback']),
                $menu['icon'],
                $menu['position']
            );
        }

        // Register submenus
        foreach (self::submenus() as $submenu_slug => $submenu) {
            add_submenu_page(
                $submenu['parent'],
                $submenu['title'],
                $submenu['title'],
                $submenu['capability'],
                $submenu_slug,
                self::get_callback($submenu['callback'])
            );
        }
    }

    /**
     * Get the callback for a menu item.
     *
     * @param mixed $callback The callback function or method.
     * @return callable|bool The callback function or false.
     */
    static function get_callback(bool|array|string $callback): callable|bool {
        if ($callback === false) {
            return false;
        }
        return is_array($callback) ? $callback : [self::class, sanitize_text_field($callback)];
    }

    /**
     * Render the main theme page.
     */
    static function render_main_page(): void {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('CEAN Theme', 'cean-wp-theme'); ?></h1>
            <p><?php echo esc_html__('Welcome to CEAN Theme settings.', 'cean-wp-theme'); ?></p>
        </div>
        <?php
    }

    /**
     * Render the settings page.
     */
    static function render_settings_page(): void {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Theme Settings', 'cean-wp-theme'); ?></h1>
            <p><?php echo esc_html__('Manage your theme settings here.', 'cean-wp-theme'); ?></p>
        </div>
        <?php
    }

    /**
     * Get the URL for a specific page.
     *
     * @param string $key The page key.
     * @return string The URL of the page.
     */
    static function get_page_url(string $key): string {
        $key = sanitize_key($key);
        if (!self::get_menu($key) && !self::get_submenu($key)) {
            wp_die(esc_html__('Page not found', 'cean-wp-theme'));
        }
        return esc_url(admin_url('admin.php?page=' . $key));
    }

    /**
     * Get the current page key from URL.
     *
     * @return string The current page key.
     */
    static function get_current_page_key(): string {
        $query = sanitize_text_field($_SERVER['QUERY_STRING'] ?? '');
        parse_str($query, $params);
        return $params['page'] ?? '';
    }

    /**
     * Get all page keys (both menus and submenus).
     *
     * @return array Array of all page keys.
     */
    static function get_all_page_keys(): array {
        return array_merge(
            array_keys(self::menus()),
            array_keys(self::submenus())
        );
    }
}