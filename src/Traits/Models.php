<?php

namespace Codad5\EasyMetabox\Traits;

use Codad5\EasyMetabox\MetaBox;

trait Models
{
    private array $metaBoxes = [];

    function get_post_type(): string
    {
        return self::POST_TYPE;
    }

    function get_expected_fields(): array
    {
        // expected fields sample data ['name' => ['required' => true, 'type' => 'string'], 'email' => ['required' => true, 'type' => 'email']]
        $expected_fields = [];
        foreach($this->metaBoxes as $metaBox) {
            foreach ($metaBox->get_fields() as $field) {
                $expected_fields[$field['id']] = ['required' => $field['attributes']['required'] ?? $field['required'] ?? false, 'type' => $field['type'], 'label' => $field['label'], 'options' => $field['options'] ?? []];
            }
        }
        return $expected_fields;
    }

    function register_metabox(MetaBox $metabox): void {
        if(in_array($metabox, $this->metaBoxes)) {
            return;
        }
        $metabox->setup_actions();
        $this->metaBoxes[] = $metabox;

    }

    final static function register_post_type(): \WP_Error|\WP_Post_Type
    {
        $args =  array_merge(self::get_post_type_args(), [
            'show_in_menu' => false
        ]);
        return register_post_type(self::POST_TYPE, $args);
    }
    /**
     * Save meta box data
     */
    function save_post($post_id): bool
    {
        try {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return false;
            }

            if (!current_user_can('edit_post', $post_id)) {
                return false;
            }
            foreach($this->metaBoxes as $metaBox) {
                $metaBox->save($post_id);
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;re
            return false;
        }

    }

    static function  get_posts($args = []): array
    {
        $args = array_merge($args, ['post_type' => self::POST_TYPE]);
        return get_posts($args);
    }

    static function get_post($id)
    {
        $post = get_post($id);
        $meta = get_post_meta($id);
        return [
            'post' => $post,
            'meta' => $meta
        ];
    }


}