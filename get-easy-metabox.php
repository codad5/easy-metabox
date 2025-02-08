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
