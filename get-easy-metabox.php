<?php
require_once __DIR__.'/src/helpers/easy-meta-box-autoloader.php';

use Codad5\EasyMetabox\MetaBox;

if ( ! function_exists('getEasyMetabox') ) {
    /**
     * Constructor for the MetaBox class
     *
     * @param string $id Unique identifier for the meta box
     * @param string $title Title displayed at the top of the meta box
     * @param string $screen Post type or screen where the meta box appears
     */
    function getEasyMetabox(string $id, string $title, string $screen): MetaBox
    {
        return new MetaBox($id, $title, $screen);
    }
}

if ( ! function_exists('easy_metabox_trait_available') ) {
    /**
     * Checks if a specific EasyMetabox trait is available
     *
     * @param string $trait_name The trait name without namespace (e.g. 'Models')
     * @return bool True if the trait exists, false otherwise
     */
    function easy_metabox_trait_available(string $trait_name): bool
    {
        $full_trait_name = "\\Codad5\\EasyMetabox\\Traits\\{$trait_name}";
        return trait_exists($full_trait_name);
    }
}

if ( ! function_exists('easy_metabox_models_trait_exists') ) {
    /**
     * Specifically checks if the Models trait is available
     *
     * @return bool True if the Models trait exists, false otherwise
     */
    function easy_metabox_models_trait_exists(): bool
    {
        return trait_exists('\\Codad5\\EasyMetabox\\Traits\\Models');
    }
}