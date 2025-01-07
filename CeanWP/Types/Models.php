<?php

namespace CeanWP\Types;

use CeanWP\Libs\MetaBox;
use WP_Error;
use WP_Post_Type;

interface Models
{
    static function init(): self;
    static function register_post_type() : WP_Error|WP_Post_Type;
    function register_metabox(MetaBox $metabox): void;
    function save_post(int $post_id): void;
    /**
     * To get the post type arguments. to be used in the register_post_type function
     */
    static function get_post_type_args(): array;

    function get_post_type();

    function get_expected_fields();
}