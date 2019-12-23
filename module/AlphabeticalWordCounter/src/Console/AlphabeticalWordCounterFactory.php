<?php

namespace AlphabeticalWordCounter\Console;

use AlphabeticalWordCounter\FactoryInterface;

class AlphabeticalWordCounterFactory implements FactoryInterface
{
    public static function createInstance()
    {
        return new AlphabeticalWordCounter();
    }
}
