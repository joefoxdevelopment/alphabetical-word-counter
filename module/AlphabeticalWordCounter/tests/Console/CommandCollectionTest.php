<?php

namespace AlphabeticalWordCounterTest\Console;

use AlphabeticalWordCounter\Console\AbstractCommand;
use AlphabeticalWordCounter\Console\CommandCollection;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    private $collection;

    public function setUp(): void
    {
        $this->collection = new CommandCollection();
    }

    public function testRegisterCommandThrowsExceptionWhenAlreadyRegisteredWithName()
    {
        $command = $this->prophesize(AbstractCommand::class);

        $this->expectException(\InvalidArgumentException::class);

        $this->collection->registerCommand($command->reveal(), 'test');
        $this->collection->registerCommand($command->reveal(), 'test');
    }
}
