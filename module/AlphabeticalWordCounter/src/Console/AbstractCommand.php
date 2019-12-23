<?php

namespace AlphabeticalWordCounter\Console;

use Assert\Assert;

abstract class AbstractCommand
{
    protected $name = null;

    public abstract function execute(): int;

    public function getName(): string {
        Assert::that($this->name)
            ->string()
            ->notEmpty();

        return $this->name;
    }
}
