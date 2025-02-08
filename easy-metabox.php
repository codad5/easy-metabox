<?php
/**
 * Plugin Name: Codad5 Sample for Easy Metabox
 * Plugin URI:  https://codad5.me
 * Description: A simple plugin to show how to use Easy Metabox in your WP plugin or theme.
 * Version:     1.0.0
 * Author:      Codad5
 * Author URI:  https://codad5.me
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: codad5-easy-metabox
 * Domain Path: /languages
 */

require_once __DIR__ . '/get-easy-metabox.php';

if (!defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}

const CEM_WORKER_POST_TYPE = 'codad5_easy_metabox';
$cem_metabox = null;

function codad5_register_worker_details(): void
{
    $labels = array(
        'name' => 'Worker Details',
        'singular_name' => 'Worker',
        'menu_name' => 'Workers',
        'name_admin_bar' => 'Worker',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Worker',
        'new_item' => 'New Worker',
        'edit_item' => 'Edit Worker',
        'view_item' => 'View Worker',
        'all_items' => 'All Workers',
        'search_items' => 'Search Workers',
        'not_found' => 'No workers found',
        'not_found_in_trash' => 'No workers found in Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-id',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'workers'),
        'show_in_rest' => true,
    );

    register_post_type(CEM_WORKER_POST_TYPE, $args);
}

add_action('init', 'codad5_register_worker_details');

function codad5_add_worker_metabox() {
    global $cem_metabox;
    $cem_metabox = getEasyMetabox(
        'worker_details',
        'Worker Details',
        CEM_WORKER_POST_TYPE
    );

    $cem_metabox->add_field('worker_position', 'Position', 'text', [], [], ['allow_quick_edit' => true]);
    $cem_metabox->add_field('worker_experience', 'Years of Experience', 'text', [], [], ['allow_quick_edit' => true]);
    $cem_metabox->add_field('worker_passport', 'Passport', 'wp_media');
    $cem_metabox->add_field('worker_department', 'Department', 'select', [
        'admin' => 'Admin',
        'hr' => 'HR',
        'engineering' => 'Engineering',
    ]);
    $cem_metabox->setup_actions();
}

function cem_save_worker_post($post_id): bool {
    global $cem_metabox;
    try {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }
        $cem_metabox->save($post_id);
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

// Custom columns implementation
function codad5_set_worker_columns($columns): array {
    $new_columns = array();

    // Preserve checkbox and title columns at the start
    if (isset($columns['cb'])) {
        $new_columns['cb'] = $columns['cb'];
    }
    if (isset($columns['title'])) {
        $new_columns['title'] = $columns['title'];
    }

    // Add our custom columns
    $new_columns['worker_position'] = __('Position', 'codad5-easy-metabox');
    $new_columns['worker_experience'] = __('Years of Experience', 'codad5-easy-metabox');

    // Add any remaining default columns
    foreach ($columns as $key => $value) {
        if (!isset($new_columns[$key])) {
            $new_columns[$key] = $value;
        }
    }

    return $new_columns;
}

function codad5_worker_column_content($column, $post_id): void {
    switch ($column) {
        case 'worker_position':
            $position = get_post_meta($post_id, 'worker_position', true);
            echo esc_html($position);
            break;

        case 'worker_experience':
            $experience = get_post_meta($post_id, 'worker_experience', true);
            echo esc_html($experience);
            break;
    }
}

function codad5_sortable_worker_columns($columns): array {
    $columns['worker_position'] = 'worker_position';
    $columns['worker_experience'] = 'worker_experience';
    return $columns;
}

function codad5_sort_worker_columns($query) {
    if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== CEM_WORKER_POST_TYPE) {
        return;
    }

    $orderby = $query->get('orderby');

    switch ($orderby) {
        case 'worker_position':
            $query->set('meta_key', 'worker_position');
            $query->set('orderby', 'meta_value');
            break;

        case 'worker_experience':
            $query->set('meta_key', 'worker_experience');
            $query->set('orderby', 'meta_value_num');
            break;
    }
}

// Register all hooks
add_action('admin_init', 'codad5_add_worker_metabox');
add_action("save_post_" . CEM_WORKER_POST_TYPE, 'cem_save_worker_post');
add_filter('manage_' . CEM_WORKER_POST_TYPE . '_posts_columns', 'codad5_set_worker_columns');
add_action('manage_' . CEM_WORKER_POST_TYPE . '_posts_custom_column', 'codad5_worker_column_content', 10, 2);
add_filter('manage_edit-' . CEM_WORKER_POST_TYPE . '_sortable_columns', 'codad5_sortable_worker_columns');
add_action('pre_get_posts', 'codad5_sort_worker_columns');