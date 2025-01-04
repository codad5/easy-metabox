<?php

namespace CeanWP\Libs;

use WP_Post;

class MetaBox
{
    private string $id;
    private string $title;
    private string $screen;
    private string $nonce;
    private string $context = 'normal'; // 'normal', 'advanced', or 'side'
    private string $priority = 'default'; // 'default', 'high', 'low', or 'core'
    private array $input_type_html = [];

    public ?WP_Post $post = null;

    private \Closure $customise_callback;


    private array $fields = [];
    function __construct($id, $title, $screen) {
        $this->id         = $id;
        $this->title      = $title;
        $this->screen     = $screen;
        $this->nonce      = $id . '-nonce';
        $this->customise_callback = fn($post) => $this->callback($post);
    }

    function set($property, $value) : MetaBox {
        $this->$property = $value;
        return $this;
    }

    /**
     * To set the nonce key
     * @param string $nonce
     */
    function set_nonce($nonce) : MetaBox {
        $this->nonce = $nonce;
        return $this;
    }

    function show( WP_Post  $post  = null) {
        $this->post = $post;
        add_meta_box(
            $this->id,
            $this->title,
            fn($post) => $this->customise_callback->__invoke($post),
            $this->screen,
            $this->context,
            $this->priority
        );
    }

    // enqueue scripts to the admin for post type ceanwp_widget
    function enqueue_scripts($path , $handle = 'ceanwp_admin_script', $deps = [], $ver = false, $in_footer = true): void {
        add_action('admin_enqueue_scripts', function() use ($path, $handle, $deps, $ver, $in_footer){
            wp_enqueue_script($handle, $path, $deps, $ver, $in_footer);
        });
    }

    function enqueue_styles($path , $handle = 'ceanwp_admin_style', $deps = [], $ver = false, $media = 'all'): void {
        add_action('admin_enqueue_scripts', function() use ($path, $handle, $deps, $ver, $media){
            wp_enqueue_style($handle, $path, $deps, $ver, $media);
        });
    }


    function add_field($id, $label, $type, $options = [], $attributes = [], $options_attributes = []): MetaBox
    {
        $this->fields[] = [
            ...$options_attributes,
            'id' => $id,
            'label' => $label,
            'type' => $type,
            'options' => $options,
            'attributes' => $attributes,
            'default' => $attributes['value'] ?? $options_attributes['default'] ?? ''
        ];
        return $this;
    }

    function set_callback(\Closure $callback): self {
        $this->customise_callback = $callback;
        return $this;
    }


    function callback($post = null) {
        wp_nonce_field(basename(__FILE__), $this->nonce);
        foreach ($this->fields as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            $field['default'] = $value;
            $this->print_input_type($field['type'], $field['id'], $field);
        }
    }

    function all_meta($post_id, string $strip = null) {
        $meta = [];
        $save_data = get_post_meta($post_id);
        foreach ($this->fields as $field) {
            // if post is given and strip out is true remove the post from the meta key '{post}_ should be deleted from the key
            $key =  $strip ? str_replace($strip . '_', '', $field['id']) : $field['id'];
            $meta[$key] = $save_data[$field['id']][0] ?? null;
        }
        return $meta;
    }

    private function setup_input_type_html(): void
    {
        $this->input_type_html = [
            'text' => function ($id, $data) {
                return $this->generate_default_input_type_html('text', $id, $data);
            },
            'textarea' => function ($id, $data) {
                return $this->generate_default_input_type_html('textarea', $id, $data);
            },
            'select' => function ($id, $data) {
                return $this->generate_default_input_type_html('select', $id, $data);
            },
            'checkbox' => function ($id, $data) {
                return $this->generate_default_input_type_html('checkbox', $id, $data);
            },
            'radio' => function ($id, $data) {
                return $this->generate_default_input_type_html('radio', $id, $data);
            },
            'number' => function ($id, $data) {
                return $this->generate_default_input_type_html('number', $id, $data);
            },
            'date' => function ($id, $data) {
                return $this->generate_default_input_type_html('date', $id, $data);
            },
            'url' => function ($id, $data) {
                return $this->generate_default_input_type_html('url', $id, $data);
            },
            'email' => function ($id, $data) {
                return $this->generate_default_input_type_html('email', $id, $data);
            },
            'tel' => function ($id, $data) {
                return $this->generate_default_input_type_html('tel', $id, $data);
            },
            'password' => function ($id, $data) {
                return $this->generate_default_input_type_html('password', $id, $data);
            },
            'hidden' => function ($id, $data) {
                return $this->generate_default_input_type_html('hidden', $id, $data);
            },
            'color' => function ($id, $data) {
                return $this->generate_default_input_type_html('color', $id, $data);
            },
            'file' => function ($id, $data) {
                return $this->generate_default_input_type_html('file', $id, $data);
            },
        ];
    }

    /**
     * Set a custom HTML generator for a specific input type.
     * @param string $type
     * @param \Closure $callback A function that generates the HTML for the input type. The function should accept the following parameters:
     * - string $id The ID of the input field.
     * - array $data The data for the input field. This includes the label, default value, and any other attributes.
     * - Major keys in
     * @return void
     */
    public function set_input_type_html(string $type, \Closure $callback): void {
        $this->input_type_html[$type] = $callback;
    }

    function generate_default_input_type_html(string $type, string $id, array $data): string {
        $default_value = esc_attr($data['default'] ?? '');
        $attributes = isset($data['attributes']) && is_array($data['attributes']) ? $data['attributes'] : [];
        $attributes['class'] = esc_attr(($attributes['class'] ?? '') . ' ceanwpmetabox-input');
        $required = !empty($attributes['required']);

        // Convert style array to string if necessary and escape
        if (isset($attributes['style'])) {
            $attributes['style'] = is_array($attributes['style']) ? esc_attr($this->style_to_string($attributes['style'])) : esc_attr($attributes['style']);
        }

        // Escape individual attributes
        $attributes_as_string = $this->attributes_to_string(array_map('esc_attr', $attributes));

        $html = "<div class=\"ceanwpmetabox-field\">";
        $html .= "<label for=\"" . esc_attr($id) . "\" class=\"ceanwpmetabox-label\">";
        $html .= esc_html($data['label']);
        $html .= $required ? '<span class="ceanwpmetabox-required">*</span>' : '';
        $html .= "</label>";

        switch ($type) {
            case 'textarea':
                $html .= "<textarea id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" $attributes_as_string>";
                $html .= esc_textarea($default_value);
                $html .= "</textarea>";
                break;

            case 'select':
                $html .= "<select id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id . (($data['attributes']['multiple'] ?? false) ? '[]' : '')) . "\" $attributes_as_string>";
                foreach ($data['options'] as $option => $option_data) {
                    $option_label = is_array($option_data) ? esc_html($option_data['label'] ?? $option) : esc_html($option_data);
                    $selected = $default_value == $option || (is_array($default_value) && in_array($option, $default_value)) ? 'selected' : '';
                    $other_attributes = is_array($option_data) ? $this->attributes_to_string(array_map('esc_attr', $option_data['attributes'] ?? [])) : '';
                    $html .= "<option value=\"" . esc_attr($option) . "\" $selected $other_attributes>";
                    $html .= esc_html($option_label);
                    $html .= "</option>";
                }
                $html .= "</select>";
                break;

            case 'checkbox':
                $checked = $default_value ? 'checked' : '';
                $html .= "<input type=\"checkbox\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"1\" $checked $attributes_as_string />";
                break;

            case 'radio':
                foreach ($data['options'] as $option => $option_data) {
                    $option_label = is_array($option_data) ? esc_html($option_data['label'] ?? $option) : esc_html($option_data);
                    $checked = $default_value == $option ? 'checked' : '';
                    $other_attributes = is_array($option_data) ? $this->attributes_to_string(array_map('esc_attr', $option_data['attributes'] ?? [])) : '';
                    $html .= "<label>";
                    $html .= "<input type=\"radio\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($option) . "\" $checked $other_attributes $attributes_as_string />";
                    $html .= esc_html($option_label);
                    $html .= "</label>";
                }
                break;

            case "number":
                $html .= "<input type=\"number\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($default_value) . "\" $attributes_as_string />";
                break;

            default:
                $html .= "<input type=\"$type\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($default_value) . "\" $attributes_as_string />";
                break;
        }

        $html .= "</div>";

        return $html;
    }

    function print_input_type(string $type, string $id, array $data): void {
        if (empty($this->input_type_html)) {
            $this->setup_input_type_html();
        }
        if (isset($this->input_type_html[$type])) {
            echo $this->input_type_html[$type]($id, $data);
            return;
        }
        echo $this->generate_default_input_type_html($type, $id, $data);
    }

    function save($post_id): bool {

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return false;
        }
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return false;
        }
        // Check if the current user is authorized to do this action
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return false;
        }
        // Check if the nonce is set.
        if ( !isset( $_POST[$this->nonce] ) ) {
            return false;
        }
        // Verify that the nonce is valid.
        $nonce = sanitize_text_field(wp_unslash($_POST[$this->nonce] ?? ''));
        if ( !wp_verify_nonce( $nonce, basename(__FILE__) ) ) {
            return false;
        }

        $names = array_map(function($field){
            return $field['id'];
        }, $this->fields);

        $final_bool = true;
        foreach ($names as $name) {
            $data = sanitize_text_field($_POST[$name] ?? '');
            // check if data is same as the one in the database
            $old_data = get_post_meta($post_id, $name, true);
            $final_bool = $final_bool && (update_post_meta($post_id, $name, $data) || $old_data == $data);
        }
        return $final_bool;
    }

    /**
     * A helper function to convert an array of CSS styles to a string format.
     * @param array $styles
     * @return string
     */
    function style_to_string(array $styles): string
    {
        $string_styles = '';
        foreach ($styles as $property => $value) {
            $string_styles .= esc_attr($property) . ': ' . esc_attr($value) . '; ';
        }
        return rtrim($string_styles);
    }

    /**
     * A helper function to convert an array of attributes to a string format.
     * @param array $attributes
     * @return string
     */
    function attributes_to_string(array $attributes): string
    {
        $string_attributes = '';
        foreach ($attributes as $key => $value) {
            $string_attributes .= esc_attr($key) . '="' . esc_attr($value) . '" ';
        }
        return rtrim($string_attributes);
    }

    /**
     * @return array
     */
    function get_fields(): array {
        return $this->fields;
    }

    function get_fields_html(): array {
        $html = [];
        foreach ($this->fields as $field) {
            $html[] = $this->generate_default_input_type_html($field['type'], $field['id'], $field);
        }
        return $html;
    }
}