<?php

namespace CeanWP\Traits;

use CeanWP\Libs\MetaBox;

trait Models
{
    private array $metaBoxes = [];

    function register_metabox(MetaBox $metabox): void {
        $this->metaBoxes[] = $metabox;
        add_action("add_meta_boxes_".self::POST_TYPE, [$metabox, 'show']);
    }

    final static function register_post_type(): \WP_Error|\WP_Post_Type
    {
        $args =  array_merge(self::get_post_type_args(), [
            'show_in_menu' => false
        ]);
//        echo "<pre>";
//        print_r($args);
//        echo "</pre>";
        return register_post_type(self::POST_TYPE, $args);
    }
    /**
     * Save meta box data
     */
    function save_post($post_id): void {
        try {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (!current_user_can('edit_post', $post_id)) {
                return;
            }

            foreach($this->metaBoxes as $metaBox) {
                $metaBox->save($post_id);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

    }



}