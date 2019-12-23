<?php

namespace AlphabeticalWordCounter\Http;

use AlphabeticalWordCounter\FactoryInterface;
use AlphabeticalWordCounter\Config\ConfigFactory;
use Assert\Assert;
use GuzzleHttp\Client;

class ClientFactory implements FactoryInterface
{
    public static function createInstance()
    {

        $config = ConfigFactory::createInstance();

        Assert::that($config)
            ->isArray()
            ->notEmptyKey('http');

        Assert::that($config['http'])
            ->isArray()
            ->notEmpty()
            ->notEmptyKey('base_uri')
            ->keyIsset('timeout');

        return new Client([
            'base_uri' => $config['http']['base_uri'],
            'timeout'  => $config['http']['timeout'],
        ]);
    }
}
