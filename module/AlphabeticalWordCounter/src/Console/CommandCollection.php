<?php

namespace AlphabeticalWordCounter\Console;

use Assert\Assert;

class CommandCollection
{
    private $commands = [];

    public function registerCommand(AbstractCommand $command, string $name = null): void
    {
        if (null === $name) {
            $name = $command->getName();
        }

        $this->assertCommandCanBeRegistered($name);

        $this->commands[$name] = $command;
    }

    public function hasCommand(string $name): bool
    {
        try {
            $this->assertCommandRegistered($name);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function runCommand(string $name): int
    {
        $this->assertCommandRegistered($name);

        return $this->commands[$name]->execute();
    }

    public function getRegisteredCommandNames(): array
    {
        return array_keys($this->commands);
    }

    private function assertCommandCanBeRegistered(string $name): void
    {
        Assert::that($name)->notEmpty();
        Assert::that($this->commands)->keyNotExists($name);
    }

    private function assertCommandRegistered(string $name): void
    {
        Assert::that($this->commands)->notEmptyKey($name);
    }
}
