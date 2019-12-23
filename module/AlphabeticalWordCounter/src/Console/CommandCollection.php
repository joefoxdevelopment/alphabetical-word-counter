<?php

namespace AlphabeticalWordCounter\Console;

use Assert\Assert;

class CommandCollection
{
    private $commands = [];

    public function registerCommand(AbstractCommand $command, ?string $name): void
    {
        if (null === $name) {
            $name = $command->getName();
        }

        $this->assertCommandRegistered($name);

        $commands[$name] = $command;
    }

    public function runCommand(string $name): int
    {
        $this->assertCommandRegistered($name);

        return $this->commands[$name]->execute();
    }

    public function hasCommand(string $name): bool
    {
        try {
            $this->assertCommandRegistered($name);
        } catch (\Exception $e) {
            return true;
        }

        return false;
    }

    private function assertCommandRegistered(string $name): void
    {
        Assert::that($name)->notEmpty();
        Assert::that($this->commands)->keyExists($name);
    }
}
