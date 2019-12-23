<?php

namespace AlphabeticalWordCounter\Config;

use AlphabeticalWordCounter\FactoryInterface;

class ConfigFactory implements FactoryInterface
{
    public static function createInstance()
    {
        $config = [];

        // Import global configs first as local config will override these
        $globals = glob('./config/autoload/*.config.global.php');
        foreach ($globals as $path) {
            $global = require $path;

            if (!is_array($global)) {
                throw new \Exception('Unable to import config array from ' . $path);
            }

            $config = array_merge_recursive($config, $global);
        }

        // Import apply local overrides
        $locals = glob('./config/autoload/*.config.local.php');
        foreach ($locals as $path) {
            $local = require $path;

            if (!is_array($local)) {
                throw new \Exception('Unable to import config array from ' . $path);
            }

            $config = array_merge_recursive($config, $local);
        }

        return $config;
    }
}
