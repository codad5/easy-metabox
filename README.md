# EasyMetabox

EasyMetabox is a WordPress library that simplifies the creation and management of custom meta boxes for posts, pages, and custom post types. It provides an intuitive API for adding custom fields with various input types and handling their data.

## Installation

Since this is a WordPress library, you can't use Composer directly unless your application compiles Composer dependencies. Here are the installation steps:

1. Download the source code from GitHub: [codad5/easy-metabox](https://github.com/codad5/easy-metabox)
2. Place the files in your WordPress plugin or theme directory
3. Include the library in your code:

```php
require_once __DIR__ . '/path-to-easy-metabox/get-easy-metabox.php';
```

## Basic Usage

Here's a simple example of how to create a meta box:

```php

// Create a new meta box
$metabox = getEasyMetabox(
    'my_meta_box',           // Unique identifier
    'Additional Information', // Meta box title
    'post'                   // Post type
);

// Add fields
$metabox->add_field('author_email', 'Author Email', 'email');
$metabox->add_field('publish_date', 'Publish Date', 'date');

// Set up the meta box
$metabox->setup_actions();
```

## Available Field Types

- text
- textarea
- select
- checkbox
- radio
- number
- date
- url
- email
- tel
- password
- hidden
- color
- file
- wp_media

## Field Configuration

When adding fields, you can specify various options:

```php
$metabox->add_field(
    'field_id',          // Field ID
    'Field Label',       // Field Label
    'text',             // Field Type
    [],                 // Options (for select, radio, checkbox)
    [                   // HTML attributes
        'class' => 'my-class',
        'required' => true,
        'placeholder' => 'Enter value'
    ],
    [                   // Additional options
        'allow_quick_edit' => true,
        'default' => 'Default value'
    ]
);
```

## Quick Edit Support

To enable quick edit support for a field:

```php
$metabox->add_field(
    'field_name',
    'Field Label',
    'text',
    [],
    [],
    ['allow_quick_edit' => true]
);
```

## WordPress Media Integration

To add a media upload field:

```php
$metabox->add_field(
    'image_field',
    'Upload Image',
    'wp_media',
    [],
    ['multiple' => true] // Allow multiple file selection
);
```

## Retrieving Meta Values

```php
// Get a single field value
$value = $metabox->get_field_value('field_id');

// Get all meta values for a post
$all_meta = $metabox->all_meta($post_id);
```

## Complete Example

Here's a complete example showing how to create a meta box for a custom post type:

```php
<?php
/**
 * Example of integrating EasyMetabox with a Custom Post Type
 */

require_once __DIR__ . '/path-to-easy-metabox/get-easy-metabox.php';

// Define post type constant
const PRODUCT_POST_TYPE = 'product';

/**
 * Register the Product custom post type
 */
function register_product_post_type(): void {
    $labels = array(
        'name'               => 'Products',
        'singular_name'      => 'Product',
        'menu_name'         => 'Products',
        'add_new'           => 'Add New',
        'add_new_item'      => 'Add New Product',
        'edit_item'         => 'Edit Product',
        'new_item'          => 'New Product',
        'view_item'         => 'View Product',
        'search_items'      => 'Search Products',
        'not_found'         => 'No products found',
        'not_found_in_trash'=> 'No products found in Trash'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-cart',
        'supports'           => array('title', 'editor', 'thumbnail')
    );

    register_post_type(PRODUCT_POST_TYPE, $args);
}

// Register the custom post type
add_action('init', 'register_product_post_type');

/**
 * Create and configure the product meta box
 */
function add_product_metabox(): void {
    global $product_metabox; // Make it accessible globally if needed

    // Initialize the meta box
    $product_metabox = getEasyMetabox(
        'product_details',    // Meta box ID
        'Product Details',    // Meta box title
        PRODUCT_POST_TYPE    // Post type to attach to
    );

    // Add fields
    $product_metabox->add_field('price', 'Price', 'number', [], [
        'required' => true,
        'min' => 0,
        'step' => 0.01
    ]);

    $product_metabox->add_field('category', 'Category', 'select', [
        'electronics' => 'Electronics',
        'clothing' => 'Clothing',
        'books' => 'Books'
    ]);

    $product_metabox->add_field('images', 'Product Images', 'wp_media', [], [
        'multiple' => true
    ]);

    // Set up the meta box actions
    $product_metabox->setup_actions();
}

// Add the meta box when WordPress initializes the admin
add_action('admin_init', 'add_product_metabox');

/**
 * Handle saving the meta box data
 */
function save_product_meta($post_id): bool {
    global $product_metabox;

    try {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        return $product_metabox->save($post_id);
    } catch (\Throwable $th) {
        return false;
    }
}

// Hook into saving the post type
add_action("save_post_" . PRODUCT_POST_TYPE, 'save_product_meta');

/**
 * Optional: Display product meta data on the front end
 */
function display_product_meta($content) {
    global $product_metabox;
    
    // Only modify product post type content
    if (!is_singular(PRODUCT_POST_TYPE)) {
        return $content;
    }

    $post_id = get_the_ID();
    $price = $product_metabox->get_field_value('price', $post_id);
    $category = $product_metabox->get_field_value('category', $post_id);
    $images = $product_metabox->get_field_value('images', $post_id, false); // false to get array of images

    $meta_html = '<div class="product-meta">';
    $meta_html .= '<p class="price">Price: $' . esc_html($price) . '</p>';
    $meta_html .= '<p class="category">Category: ' . esc_html($category) . '</p>';
    
    if (!empty($images)) {
        $meta_html .= '<div class="product-gallery">';
        foreach ($images as $image_url) {
            $meta_html .= '<img src="' . esc_url($image_url) . '" alt="Product Image">';
        }
        $meta_html .= '</div>';
    }
    
    $meta_html .= '</div>';

    return $content . $meta_html;
}

// Add meta data to the content
add_filter('the_content', 'display_product_meta');
```

## Validation

The library includes built-in validation for field types. You can show admin errors by enabling them:

```php
$metabox->set_show_admin_error(true);
```

## Prefix Support

You can set a prefix for all field IDs:

```php
$metabox->set_prefix('my_prefix_');
```

## Custom Input Types

You can add custom input types:

```php
$metabox->set_input_type_html('custom_type', function($id, $data) {
    // Return HTML string for custom input type
    return "<input type='text' id='{$id}' name='{$id}' />";
});
```

## License

This project is licensed under the GPL-2.0+ License.

## Author

Created by [Codad5](https://codad5.me)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.