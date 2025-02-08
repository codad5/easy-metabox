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
        'menu_icon' => 'dashicons-id', // WordPress dashicon for workers
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'workers'),
        'show_in_rest' => true, // Enables Gutenberg support
    );

    register_post_type(CEM_WORKER_POST_TYPE, $args);
}

add_action('init', 'codad5_register_worker_details');

/**
 * Example usage of Easy Metabox with Worker Details CPT
 */
function codad5_add_worker_metabox()
{
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

function cem_save_worker_post($post_id): bool
{
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
        //throw $th;re
        return false;
    }
}

add_action('admin_init', 'codad5_add_worker_metabox');
add_action("save_post_".CEM_WORKER_POST_TYPE,  'cem_save_worker_post');
