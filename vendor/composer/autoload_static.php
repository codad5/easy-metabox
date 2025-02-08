<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4f4ab6c0fdaa7dfd87461c5d9b898055
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Codad5\\EasyMetabox\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Codad5\\EasyMetabox\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4f4ab6c0fdaa7dfd87461c5d9b898055::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4f4ab6c0fdaa7dfd87461c5d9b898055::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4f4ab6c0fdaa7dfd87461c5d9b898055::$classMap;

        }, null, ClassLoader::class);
    }
}
