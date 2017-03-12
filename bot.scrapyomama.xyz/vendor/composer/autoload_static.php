<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit12eebf84ca89cad7c89d0b6dd6d554fa
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pecee\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pecee\\' => 
        array (
            0 => __DIR__ . '/..' . '/pecee/http-service/src/Pecee',
            1 => __DIR__ . '/..' . '/pecee/tinder-sdk/src/Pecee',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit12eebf84ca89cad7c89d0b6dd6d554fa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit12eebf84ca89cad7c89d0b6dd6d554fa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
