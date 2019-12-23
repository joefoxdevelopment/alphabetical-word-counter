<?php

namespace AlphabeticalWordCounter\Console;

use Assert\Assert;
use AlphabeticalWordCounter\FactoryInterface;
use AlphabeticalWordCounter\Http\ClientFactory;
use AlphabeticalWordCounter\Config\ConfigFactory;

class AlphabeticalWordCounterFactory implements FactoryInterface
{
    public static function createInstance()
    {
        $client = ClientFactory::createInstance();
        $config = ConfigFactory::createInstance();

        Assert::that($config)
            ->isArray()
            ->notEmptyKey('file');

        return new AlphabeticalWordCounter($client, $config['file']);
    }
}
