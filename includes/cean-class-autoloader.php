<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit();
}


// simple autoloader file to load
spl_autoload_register( function ( $class ) {
    $class = str_replace( '\\', DIRECTORY_SEPARATOR, $class );
    if ( ! str_starts_with( $class, 'CeanWP') ) {
        return;
    }
    $class = str_replace( 'CeanWP' . DIRECTORY_SEPARATOR, '', $class );
    $class_file = __DIR__ . '/../CeanWP'.DIRECTORY_SEPARATOR . $class . '.php';
    if ( file_exists( $class_file ) ) {
        require_once $class_file;
    }
} );