<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

// Try to use Composer's autoloader first
if ( file_exists( __DIR__ . '/../../vendor/autoload.php' ) ) {
    require_once __DIR__ . '/../../vendor/autoload.php';
    return;
}

// Fallback to custom autoloader if Composer's autoloader is unavailable
spl_autoload_register( function ( $class ) {
    $class = str_replace( '\\', DIRECTORY_SEPARATOR, $class );

    if ( ! str_starts_with( $class, 'Codad5' . DIRECTORY_SEPARATOR . 'EasyMetabox' ) ) {
        return;
    }

    $class = str_replace( 'Codad5' . DIRECTORY_SEPARATOR . 'EasyMetabox' . DIRECTORY_SEPARATOR, '', $class );
    $class_file = __DIR__ . '/../Codad5/EasyMetabox/' . $class . '.php';

    if ( file_exists( $class_file ) ) {
        require_once $class_file;
    }
});
