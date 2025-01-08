<?php

namespace CeanWP\Models;

use CeanWP\Controllers\CountryHelper;
use CeanWP\Libs\MetaBox;
use CeanWP\Types\Models;
use CeanWP\Traits\Models as ModelsTrait;
use WP_Error;
use WP_Post_Type;

class CeanWP_Contact_Form implements Models
{

    use ModelsTrait;

    const POST_TYPE = 'cean_contact_form';
    const META_PREFIX = '_cean_contact_';
    const INQUIRY_TYPES = [
        'general' => 'General Inquiry',
        'support' => 'Support Request',
        'feedback' => 'Feedback',
    ];
    const HEARD_ABOUT_US = [
        'google' => 'Google',
        'social_media' => 'Social Media',
        'friend' => 'Friend',
    ];

    static CeanWP_Contact_Form $instance;

    static function get_instance(): self
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new self();
        // Register post type and meta boxes
        add_action('init', [self::$instance, 'register_post_type']);
        add_action('save_post', [self::$instance, 'save_post']);

        // Add custom admin table columns
        add_filter('manage_' . self::POST_TYPE . '_posts_columns', [self::$instance, 'set_custom_columns']);
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', [self::$instance, 'custom_column_content'], 10, 2);

        self::$instance->setup_metabox();

        return self::$instance;
    }

    static function get_post_type_args(): array
    {
        return array(
            'labels'              => array(
                'name'               => __('Contact Form Submissions', 'cean-wp-theme'),
                'singular_name'      => __('Submission', 'cean-wp-theme'),
                'add_new'            => __('Add New Submission', 'cean-wp-theme'),
                'add_new_item'       => __('Add New Submission', 'cean-wp-theme'),
                'edit_item'          => __('Edit Submission', 'cean-wp-theme'),
                'view_item'          => __('View Submission', 'cean-wp-theme'),
                'search_items'       => __('Search Submissions', 'cean-wp-theme'),
                'not_found'          => __('No submissions found', 'cean-wp-theme'),
            ),
            'public'              => false,
            'show_ui'             => true,
            'menu_icon'           => 'dashicons-email',
            'supports'            => ['title'],
            'show_in_rest'        => false,
            'capability_type'     => 'post',
            'capabilities'        => array(
                'create_posts' => 'do_not_allow',
            ),
        );

    }

    function set_custom_columns(array $columns): array
    {
        $new_columns = [];

        // Include default columns
        if (isset($columns['cb'])) {
            $new_columns['cb'] = $columns['cb'];
        }

        $new_columns['title'] = __('Submission Title', 'cean-wp-theme');
        $new_columns['email'] = __('Email', 'cean-wp-theme');
        $new_columns['date'] = __('Date', 'cean-wp-theme');

        return $new_columns;
    }

    function custom_column_content(string $column, int $post_id): void
    {
        switch ($column) {
            case 'email':
                $email = get_post_meta($post_id, self::META_PREFIX . 'email', true);
                echo esc_html($email);
                break;
        }
    }

    function setup_metabox(): void
    {
        $meta_box = new MetaBox('contact_details', 'Contact Details', self::POST_TYPE);

        $meta_box->add_field(self::META_PREFIX . 'first_name', 'First Name', 'text');
        $meta_box->add_field(self::META_PREFIX . 'last_name', 'Last Name', 'text');
        $meta_box->add_field(self::META_PREFIX . 'email', 'Email', 'email');
//        country option
        $meta_box->add_field(self::META_PREFIX . 'country', 'Country', 'select', CountryHelper::getAllCountriesPhoneCode());
        $meta_box->add_field(self::META_PREFIX . 'phone', 'Phone Number', 'text');
        $meta_box->add_field(self::META_PREFIX . 'inquiry_type', 'Inquiry Type', 'select', self::INQUIRY_TYPES);
        $meta_box->add_field(self::META_PREFIX . 'heard_about_us', 'How Did You Hear About Us?', 'select', self::HEARD_ABOUT_US);
        $meta_box->add_field(self::META_PREFIX . 'message', 'Message', 'textarea');

        $this->register_metabox($meta_box);
    }



    static function save_post_from_frontend($data)
    {
        /* exmaple of data Array
(
    [_cean_contact_first_name] => Chibueze
    [_cean_contact_last_name] => Aniezeofor
    [_cean_contact_email] => Aniezeoformic@gmail.com
    [_cean_contact_country] => ng
    [_cean_contact_phone] => 08142572488
    [_cean_contact_inquiry_type] => General Inquiry
    [_cean_contact_heard_about_us] => Friend
    [_cean_contact_message] => Something
)*/
        $post_data = [
            'post_title' => $data['_cean_contact_first_name'] . ' ' . $data['_cean_contact_last_name'],
            'post_type' => self::POST_TYPE,
            'post_status' => 'publish',
            'meta_input' => [
                self::META_PREFIX . 'first_name' => $data['_cean_contact_first_name'],
                self::META_PREFIX . 'last_name' => $data['_cean_contact_last_name'],
                self::META_PREFIX . 'email' => $data['_cean_contact_email'],
                self::META_PREFIX . 'country' => $data['_cean_contact_country'],
                self::META_PREFIX . 'phone' => $data['_cean_contact_phone'],
                self::META_PREFIX . 'inquiry_type' => $data['_cean_contact_inquiry_type'],
                self::META_PREFIX . 'heard_about_us' => $data['_cean_contact_heard_about_us'],
                self::META_PREFIX . 'message' => $data['_cean_contact_message'],
            ]
        ];

        $post_id = wp_insert_post($post_data);
        if (is_wp_error($post_id)) {
            return $post_id;
        }
        // send email to admin
        $email = get_option('admin_email');
        $subject = "New Contact Form Submission from {$data['_cean_contact_first_name']} {$data['_cean_contact_last_name']}";
        $message = $data['_cean_contact_message'];
        return wp_mail($email, $subject, $message);
    }

}