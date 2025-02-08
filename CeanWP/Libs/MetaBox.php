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

    /** @var string Path to templates directory */
    private string $templates_path;
    private string $meta_prefix = '';

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

        // Set templates path - you might want to make this configurable
        $this->templates_path = get_template_directory() . 'templates-parts/';

        // Make sure to add wp_enqueue_media() when needed
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_media();
            $this->enqueue_quick_edit_script();
        });

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

    function get_quick_edit_nonce(): string
    {
        return "cean-quick-edit-{$this->nonce}";
    }

    function set_prefix(string $prefix) : MetaBox {
        $this->meta_prefix = $prefix;
        return $this;
    }

    function setup_actions()
    {
        add_action("add_meta_boxes_".$this->screen, [$this, 'show']);
        add_action('quick_edit_custom_box', [$this, 'show_quick_edit_field'], 10, 2);
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


    function show_quick_edit_field($column_name, $post_type)
    {
        if ($post_type !== $this->screen) return;
        static $printNonce = TRUE;
        if ($printNonce) {
            $printNonce = FALSE;
            wp_nonce_field(basename(__FILE__), $this->nonce);
            wp_nonce_field(basename(__FILE__), $this->get_quick_edit_nonce());
        }

        $field = $this->get_field('id', $column_name);
//        var_dump($field, $column_name);
        if(!$field) return;
        if(isset($field['allow_quick_edit']) && $field['allow_quick_edit'] === true) {
            $field['default'] = $this->get_field_value($field['id']);
            $this->print_input_type($field['type'], $field['id'], $field);
        }

    }

    /**
     * Enqueue Quick Edit JavaScript
     */
    function enqueue_quick_edit_script(): void
    {
        $screen = get_current_screen();

        // Only add to Movies admin list
        if ($screen->post_type !== $this->screen || $screen->base !== 'edit') {
            return;
        }

        wp_enqueue_script('cean-movie-quick-edit', get_template_directory_uri() . '/assets/scripts/movie-quick-edit.js', ['jquery', 'inline-edit-post'], '1.0.0', true);
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
        if(!empty($this->meta_prefix) && !str_starts_with($id, $this->meta_prefix)) {
            $id = $this->meta_prefix . $id;
        }
        $this->fields[] = array_merge($options_attributes, [
            'id' => $id,
            'label' => $label,
            'type' => $type,
            'options' => $options,
            'attributes' => $attributes,
            'default' => $attributes['value'] ?? $options_attributes['default'] ?? '',
            'allow_quick_edit' => $options_attributes['allow_quick_edit'] ?? false
        ]);
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
        echo '<div class="form-wrap">';  // Added form-wrap here
        foreach ($this->fields as $field) {
            $m = isset($field['attributes']['multiple']) && $field['attributes']['multiple'] == true;
            $value = get_post_meta($post->ID, $field['id'], !$m);
            $field['default'] = $value;
            $this->print_input_type($field['type'], $field['id'], $field);
        }
        echo '</div>';  // Close form-wrap
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
            'wp_media' => function ($id, $data) {
                return $this->generate_default_input_type_html('wp_media', $id, $data);
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

        // Default to no regular-text class to prevent overly wide inputs
        $default_class = '';

        // Add specific classes based on input type
        switch ($type) {
            case 'text':
            case 'email':
            case 'url':
            case 'select':
            case 'textarea':
            case 'password':
                $default_class = 'widefat';
                break;
            case 'number':
                $default_class = 'small-text';
                break;
        }

        // Merge default class with any custom classes
        $attributes['class'] = esc_attr(($attributes['class'] ?? '') . ' ' . $default_class);
        $required = !empty($attributes['required']);

        if (isset($attributes['style'])) {
            $attributes['style'] = is_array($attributes['style']) ? esc_attr($this->style_to_string($attributes['style'])) : esc_attr($attributes['style']);
        }
        $attributes_as_string = $this->attributes_to_string($attributes);

        // Remove form-wrap, keep only form-field
        $html = "<div class=\"form-field\" style=\"max-width: 500px;\">";
        $html .= "<label for=\"" . esc_attr($id) . "\" class=\"form-label\">";
        $html .= esc_html($data['label']);
        $html .= $required ? '<span class="required">*</span>' : '';
        $html .= "</label>";

        switch ($type) {
            case 'textarea':
                $html .= "<textarea id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" style=\"height: 100px;\" $attributes_as_string>";
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
                $html .= "<span class=\"checkbox-wrap\">";
                $checked = $default_value ? 'checked' : '';
                $html .= "<input type=\"checkbox\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"1\" $checked $attributes_as_string />";
                $html .= "</span>";
                break;

            case 'radio':
                $html .= "<div class=\"radio-wrap\">";
                foreach ($data['options'] as $option => $option_data) {
                    $option_label = is_array($option_data) ? esc_html($option_data['label'] ?? $option) : esc_html($option_data);
                    $checked = $default_value == $option ? 'checked' : '';
                    $other_attributes = is_array($option_data) ? $this->attributes_to_string(array_map('esc_attr', $option_data['attributes'] ?? [])) : '';
                    $html .= "<label class=\"radio-label\">";
                    $html .= "<input type=\"radio\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($option) . "\" $checked $other_attributes $attributes_as_string />";
                    $html .= esc_html($option_label);
                    $html .= "</label>";
                }
                $html .= "</div>";
                break;

            case "number":
                $html .= "<input type=\"number\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($default_value) . "\" $attributes_as_string />";
                break;

            case "wp_media":
                $html .= "<div class=\"wp-media-buttons\">";
                $html .= $this->generate_wp_media_html($id, $data);
                $html .= "</div>";
                break;

            default:
                $html .= "<input type=\"$type\" id=\"" . esc_attr($id) . "\" name=\"" . esc_attr($id) . "\" value=\"" . esc_attr($default_value) . "\" $attributes_as_string />";
                break;
        }

        // Add description if it exists
        if (!empty($data['description'])) {
            $html .= "<p class=\"description\">" . esc_html($data['description']) . "</p>";
        }

        $html .= "</div>"; // .form-field

        return $html;
    }


    /**
     * Generates HTML for WordPress media input using template
     *
     * @param string $id Field identifier
     * @param array $data Field configuration data
     * @return string Generated HTML
     */
    private function generate_wp_media_html(string $id, array $data): string
    {
        $default_value = $data['default'] ?? '';
        $attributes = isset($data['attributes']) && is_array($data['attributes']) ? $data['attributes'] : [];
        $attributes['class'] = esc_attr(($attributes['class'] ?? '') . ' ceanwpmetabox-input');
        $required = !empty($attributes['required']);
        $multiple = $attributes['multiple'] ?? false;
        $attributes_as_string = $this->attributes_to_string($attributes);
        $label = $data['label'];
        // Start output buffering
        ob_start();

        get_template_part('template-parts/metabox/media-field', null, array(
            'id' => $id,
            'label' => $label,
            'default_value' => $default_value,
            'attributes' => $attributes,
            'required' => $required,
            'attributes_as_string' => $attributes_as_string,
            'multiple' => $multiple,
        ));

        // Get the buffered content
        return ob_get_clean();
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

        $is_quick_edit = false;
        $quick_edit_nonce = sanitize_text_field(wp_unslash($_POST[$this->get_quick_edit_nonce()] ?? ''));
        if (wp_verify_nonce( $quick_edit_nonce, basename(__FILE__) ) ) {
            $is_quick_edit = true;
        }
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE && !$is_quick_edit) {
            return false;
        }
        if (defined('DOING_AJAX') && DOING_AJAX && !$is_quick_edit) {
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

        $check_field = $this->fields;
        if($is_quick_edit){
            $check_field = array_filter($check_field, fn($field) => $field['allow_quick_edit'] === true);
        }
        $has_error = array_filter($check_field, function($field){
            if((empty($_POST[$field['id']])) && ($field['attributes']['required'] ?? false) === false){
                return false;
            }
           $valid = InputValidator::validate($field['type'], $_POST[$field['id']], $field);
           return !$valid;
        });

        if(!empty($has_error)){
            var_dump("has error");
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

//        $names = array_map(function($field){
//            return $field['id'];
//        }, $check_field);


        return $this->save_fields($post_id);
    }


    /**
     * Saves field values to post meta
     */
    private function save_fields(int $post_id): bool {
        $success = true;
        foreach ($this->fields as $field) {
            $field_id = $field['id'];

            if ($field['type'] === 'wp_media') {
                // Handle multiple media values
                $media_ids = isset($_POST[$field_id]) ? (array) $_POST[$field_id] : [];
                $sanitized_ids = array_map('absint', $media_ids);

                // Delete existing meta
                delete_post_meta($post_id, $field_id);

                // Add new values
                foreach ($sanitized_ids as $media_id) {
                    if ($media_id > 0) {
                        $success = add_post_meta($post_id, $field_id, $media_id) !== false;
                    }
                }
            } else {
                $value = $_POST[$field_id] ?? '';
                $sanitized_value = $this->sanitize_field_value($value, $field['type']);

                // Check if the meta exists
                $exists = metadata_exists('post', $post_id, $field_id);

                if ($exists) {
                    // Update existing meta
                    $old_value = get_post_meta($post_id, $field_id, true);
                    $old_value = $this->sanitize_field_value($old_value, $field['type']);
                    if ($old_value !== $sanitized_value) {
                        $success = $success && (update_post_meta($post_id, $field_id, $sanitized_value) !== false);
                    }
                } else {
                    // Add new meta
                    $success = $success && (add_post_meta($post_id, $field_id, $sanitized_value, true) !== false);
                }
            }
        }
        return $success;
    }
    /**
     * Sanitizes field value based on type
     */
    private function sanitize_field_value($value, string $type): int|string
    {
        return match ($type) {
            'wp_media', 'number' => absint($value),
            default => sanitize_text_field($value),
        };
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
            if(strtolower($key) === 'required' && !$value){
                continue;
            }
            $string_attributes .= esc_attr($key) . '="' .  esc_attr($value) . '" ';
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
     * Gets a specific field by its property value
     *
     * @param string $by The property to search by (e.g., 'id', 'label', 'type')
     * @param mixed $value The value to match
     * @return array|null Returns the field configuration array if found, null otherwise
     */
    function get_field(string $by, mixed $value): ?array
    {
        if($by == 'id' && !empty($this->meta_prefix) && !str_starts_with($value, $this->meta_prefix)) {
            $value = $this->meta_prefix . $value;
        }
        foreach ($this->fields as $field) {
            if (isset($field[$by]) && $field[$by] === $value) {
                return $field;
            }
        }
        return null;
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

    /**
     * Gets the value of a specific field for a given post
     *
     * @param string $field_id The ID of the field
     * @param int|null $post_id Post ID (defaults to current post)
     * @param bool $single Whether to return a single value (true) or array of values (false)
     * @return mixed The field value(s) or null if not found
     */
    function get_field_value(string $field_id, ?int $post_id = null, bool $single = true): mixed
    {
        // If no post_id provided, try to get from current post
        if (is_null($post_id)) {
            $post_id = $this->post?->ID ?? get_the_ID();
            if (!$post_id) {
                return null;
            }
        }

        // Check if field exists
        $field = $this->get_field('id', $field_id);
        if (!$field) {
            return null;
        }

        // Get the value from post meta
        $value = get_post_meta($post_id, $field_id, $single);

        // If no value and field has default, return default
        if (($value === '' || $value === false) && isset($field['default'])) {
            return $field['default'];
        }

        // For wp_media type, maybe get attachment URL
        if ($field['type'] === 'wp_media') {
            if ($single) {
                return wp_get_attachment_url($value) ?: $value;
            } else {
                return array_map(function($id) {
                    return wp_get_attachment_url($id) ?: $id;
                }, $value);
            }
        }

        return $value;
    }



}