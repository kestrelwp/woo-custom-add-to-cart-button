<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3b56662dd42fb73dc0626fbc3471339
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Barn2\\WCB_Lib\\' => 14,
            'Barn2\\Plugin\\WC_Custom_Cart_Button\\' => 35,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Barn2\\WCB_Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'Barn2\\Plugin\\WC_Custom_Cart_Button\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitd3b56662dd42fb73dc0626fbc3471339::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd3b56662dd42fb73dc0626fbc3471339::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd3b56662dd42fb73dc0626fbc3471339::$classMap;

        }, null, ClassLoader::class);
    }
}
