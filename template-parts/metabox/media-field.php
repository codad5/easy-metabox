
<?php
/**
 * Template for media field in MetaBox with multi-select support
 *
 * @var string $id Field identifier
 * @var string $label Field label
 * @var string|array $default_value Default/current value(s)
 * @var array $attributes Field attributes
 * @var bool $required Whether the field is required
 * @var string $attributes_as_string HTML attributes as string
 * @var bool $multiple Whether multiple selection is allowed
 * @var array $args Arguments passed to the template
 */

[
    'id' => $id,
    'label' => $label,
    'default_value' => $default_value,
    'attributes' => $attributes,
    'required' => $required,
    'attributes_as_string' => $attributes_as_string,
    'multiple' => $multiple,
] = $args;

// Ensure default_value is always an array for consistency
$values = is_array($default_value) ? $default_value : ($default_value ? [$default_value] : []);
?>
<div class="ceanwpmetabox-field ceanwpmetabox-media-field form-field">
    <div class="media-items-container" id="<?php echo esc_attr($id . '_container'); ?>">
        <?php foreach ($values as $media_id): ?>
            <div class="media-item" data-media-id="<?php echo esc_attr($media_id); ?>">
                <?php
                $image_url = wp_get_attachment_image_url($media_id, 'thumbnail');
                if ($image_url) {
                    echo '<img src="' . esc_url($image_url) . '" alt="Preview" />';
                } else {
                    $file_url = wp_get_attachment_url($media_id);
                    $file_type = get_post_mime_type($media_id);
                    echo '<div class="non-image-preview">';
                    echo '<span class="dashicons dashicons-media-default"></span>';
                    echo '<span class="filename">' . esc_html(basename($file_url)) . '</span>';
                    echo '</div>';
                }
                ?>
                <button type="button" class="remove-single-media button-link" title="Remove this item">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
                <input type="hidden" name="<?php echo esc_attr($id); ?>[]" value="<?php echo esc_attr($media_id); ?>" />
            </div>
        <?php endforeach; ?>
    </div>

    <div class="media-buttons">
        <button type="button" id="<?php echo esc_attr($id . '_button'); ?>" class="button select-media-button">
            Select <?php echo $multiple ? 'Media Files' : 'Media File'; ?>
        </button>
        <?php if ($multiple): ?>
            <button type="button" class="button clear-all-media" style="display: <?php echo !empty($values) ? 'inline-block' : 'none'; ?>">
                Clear All
            </button>
        <?php endif; ?>
    </div>

    <style>
        .media-items-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 10px 0;
        }
        .media-item {
            position: relative;
            width: 150px;
            padding: 5px;
            border: 1px solid #ddd;
            background: #fff;
        }
        .media-item img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .non-image-preview {
            padding: 10px;
            text-align: center;
            background: #f7f7f7;
        }
        .remove-single-media {
            position: absolute;
            top: 5px;
            right: 5px;
            color: #dc3232;
            cursor: pointer;
            padding: 0;
            background: rgba(255,255,255,0.8);
            border-radius: 50%;
        }
        .filename {
            display: block;
            font-size: 12px;
            word-break: break-all;
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            var frame;
            var container = $('#<?php echo esc_js($id . '_container'); ?>');
            var multiple = <?php echo $multiple ? 'true' : 'false'; ?>;
            console.clear()
            console.log(multiple)

            $('#<?php echo esc_js($id . '_button'); ?>').click(function(e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Select Media',
                    button: {
                        text: 'Use selected media'
                    },
                    multiple: multiple
                });

                frame.on('select', function() {
                    var attachments = frame.state().get('selection').toJSON();

                    if (!multiple) {
                        container.empty();
                        attachments = [attachments[0]];
                    }

                    attachments.forEach(function(attachment) {
                        var preview = '';
                        if (attachment.type === 'image') {
                            preview = '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="Preview" />';
                        } else {
                            preview = '<div class="non-image-preview">' +
                                '<span class="dashicons dashicons-media-default"></span>' +
                                '<span class="filename">' + attachment.filename + '</span>' +
                                '</div>';
                        }

                        var item = $('<div class="media-item" data-media-id="' + attachment.id + '">' +
                            preview +
                            '<button type="button" class="remove-single-media button-link" title="Remove this item">' +
                            '<span class="dashicons dashicons-no-alt"></span>' +
                            '</button>' +
                            '<input type="hidden" name="<?php echo esc_js($id); ?>[]" value="' + attachment.id + '" />' +
                            '</div>');

                        container.append(item);
                    });

                    $('.clear-all-media').show();
                });

                frame.open();
            });

            container.on('click', '.remove-single-media', function() {
                $(this).closest('.media-item').remove();
                if (container.find('.media-item').length === 0) {
                    $('.clear-all-media').hide();
                }
            });

            $('.clear-all-media').click(function() {
                container.empty();
                $(this).hide();
            });
        });
    </script>
</div>