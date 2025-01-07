<?php

namespace CeanWP\Libs;

use WP_Post;


/**
 * MetaBox Class
 *
 * Creates and manages custom meta boxes for WordPress posts/pages with various input types.
 * Handles the creation, display, and saving of custom meta fields.
 *
 * @package CeanWP\Libs
 */
class MetaBox
{
    /** @var string Unique identifier for the meta box */
    private string $id;

    /** @var string Title displayed at the top of the meta box */
    private string $title;

    /** @var string Post type or screen where the meta box appears */
    private string $screen;

    /** @var string Nonce field name for security verification */
    private string $nonce;

    /** @var string Context where the meta box appears ('normal', 'advanced', or 'side') */
    private string $context = 'normal';

    /** @var string Priority of the meta box ('default', 'high', 'low', or 'core') */
    private string $priority = 'default';

    /** @var array HTML generators for different input types */
    private array $input_type_html = [];

    /** @var ?WP_Post Current post object */
    public ?WP_Post $post = null;

    /** @var \Closure Callback function for rendering meta box content */
    private \Closure $customise_callback;

    /** @var array Collection of field configurations */
    private array $fields = [];

    /** @var bool Show admin error */
    private bool $show_admin_error = true;

    /**
     * Constructor for the MetaBox class
     *
     * @param string $id Unique identifier for the meta box
     * @param string $title Title displayed at the top of the meta box
     * @param string $screen Post type or screen where the meta box appears
     */
    function __construct(string $id, string $title, string $screen) {
        $this->id         = $id;
        $this->title      = $title;
        $this->screen     = $screen;
        $this->nonce      = $id . '-nonce';
        $this->customise_callback = fn($post) => $this->callback($post);
        $this->show_admin_error();
    }

    /**
     * Generic setter for class properties
     *
     * @param string $property Name of the property to set
     * @param mixed $value Value to set
     * @return MetaBox Returns self for method chaining
     */
    function set(string $property, mixed $value) : MetaBox {
        $this->$property = $value;
        return $this;
    }

    /**
     * Sets custom nonce key for the meta box
     *
     * @param string $nonce Custom nonce key
     * @return MetaBox Returns self for method chaining
     */
    function set_nonce(string $nonce) : MetaBox {
        $this->nonce = $nonce;
        return $this;
    }

    /**
     * Sets the context where the meta box appears
     *
     * @param bool $show_admin_error
     * @return void Returns self for method chaining
     */
    function set_show_admin_error(bool $show_admin_error): void {
        $this->show_admin_error = $show_admin_error;
    }


    /**
     * Adds the meta box to WordPress admin
     *
     * @param WP_Post|null $post Current post object
     * @return void
     */
    function show( WP_Post  $post  = null): void
    {
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


    /**
     * Adds a new field to the meta box
     *
     * @param string $id Unique identifier for the field
     * @param string $label Label displayed above the field
     * @param string $type Input type (text, textarea, select, etc.)
     * @param array $options Options for select, radio, checkbox fields
     * @param array $attributes HTML attributes for the input
     * @param array $options_attributes Additional options for field configuration
     * @return MetaBox Returns self for method chaining
     */
    function add_field(string $id, string $label, string $type, array $options = [], array $attributes = [], array $options_attributes = []): MetaBox
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

    /**
     * Sets custom callback for meta box content rendering
     *
     * @param \Closure $callback Function to render meta box content
     * @return self Returns self for method chaining
     */
    function set_callback(\Closure $callback): self {
        $this->customise_callback = $callback;
        return $this;
    }


    /**
     * Default callback for rendering meta box content
     *
     * @param WP_Post|null $post Current post object
     * @return void
     */
    function callback(WP_Post $post = null): void
    {
        wp_nonce_field(basename(__FILE__), $this->nonce);
        foreach ($this->fields as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            $field['default'] = $value;
            $this->print_input_type($field['type'], $field['id'], $field);
        }
    }

    /**
     * Retrieves all meta values for a post
     *
     * @param int $post_id Post ID
     * @param string|null $strip Prefix to strip from meta keys
     * @return array Array of meta values
     */
    function all_meta(int $post_id, string $strip = null): array
    {
        $meta = [];
        $save_data = get_post_meta($post_id);
        foreach ($this->fields as $field) {
            // if post is given and strip out is true remove the post from the meta key '{post}_ should be deleted from the key
            $key =  $strip ? str_replace($strip . '_', '', $field['id']) : $field['id'];
            $meta[$key] = $save_data[$field['id']][0] ?? null;
        }
        return $meta;
    }

    /**
     * Sets up default HTML generators for different input types
     *
     * @return void
     */
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
            'option' => function ($id, $data) {
                return $this->generate_default_input_type_html('option', $id, $data);
            },
        ];
    }

    /**
     * Set a custom HTML generator for a specific input type.
     * @param string $type
     * @param \Closure $callback A function that generates the HTML for the input type. The function should accept the following parameters:
     * - string $id The ID of the input field.
     * - array $data The data for the input field. This includes the label, default value, and any other attributes.
     * - Major keys in the $data array:
     *   - label: The label for the input field.
     *   - default: The default value for the input field.
     *   - attributes: An array of HTML attributes for the input field.
     *   - options: An array of options for select, radio, and checkbox fields.
     *   - options_attributes: Additional options for field configuration.
     * @return void
     */
    public function set_input_type_html(string $type, \Closure $callback): void {
        $this->input_type_html[$type] = $callback;
    }

    /**
     * Generates HTML for default input types
     *
     * @param string $type Input type
     * @param string $id Field identifier
     * @param array $data Field configuration data
     * @return string Generated HTML
     */
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

            case 'select' :
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

    /**
     * Outputs HTML for a specific input type
     *
     * @param string $type Input type
     * @param string $id Field identifier
     * @param array $data Field configuration data
     * @return void
     */
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

    /**
     * Saves meta box field values
     *
     * @param int $post_id Post ID
     * @return bool Success status
     */
    function save(int $post_id): bool {

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

        $has_error = array_filter($this->fields, function($field){
           $valid = InputValidator::validate($field['type'], $_POST[$field['id']] ?? '', $field);
           return !$valid;
        });

        if(!empty($has_error)){
            if($this->show_admin_error){
                add_filter('redirect_post_location', function($location) use ($has_error){
                    $error_message = implode(', ', array_map(function($field){
                        return $field['label'];
                    }, $has_error));
                    set_transient('ceanwp_error', urlencode("Error saving fields: \" {$error_message} \" "), 30);
                    return add_query_arg('ceanwp_error', urlencode("Error saving fields: {$error_message}"), $location);
                });
            }
            remove_action('save_post', [$this, 'save']);
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

    function show_admin_error(): void
    {
        if($this->show_admin_error){
            add_action('admin_notices', [$this, 'admin_error']);
        }
    }

    function admin_error(): void {
        $error = get_transient('ceanwp_error');
        if($error){
            $error = urldecode($error);
            echo "<div class='notice notice-error is-dismissible'><p>{$error}</p></div>";
            delete_transient('ceanwp_error');
        }
    }

    /**
     * Converts array of CSS styles to string
     *
     * @param array $styles Array of CSS properties and values
     * @return string CSS string
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
     * Converts array of HTML attributes to string
     *
     * @param array $attributes Array of HTML attributes and values
     * @return string Attributes string
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
     * Gets all registered fields
     *
     * @return array Array of field configurations
     */
    function get_fields(): array {
        return $this->fields;
    }

    /**
     * Gets HTML for all registered fields
     *
     * @return array Array of generated HTML for each field
     */
    function get_fields_html(): array {
        $html = [];
        foreach ($this->fields as $field) {
            $html[] = $this->generate_default_input_type_html($field['type'], $field['id'], $field);
        }
        return $html;
    }



}