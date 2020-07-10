<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcd7d870935378da257c35bfc177db684
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/hcodebr/php-classes/src',
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
        'R' => 
        array (
            'Rain' => 
            array (
                0 => __DIR__ . '/..' . '/rain/raintpl/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInitcd7d870935378da257c35bfc177db684::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitcd7d870935378da257c35bfc177db684::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
