<?php

namespace AlphabeticalWordCounterTest\Console;

use AlphabeticalWordCounter\Console\AbstractCommand;
use AlphabeticalWordCounter\Console\CommandCollection;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    private $collection;
    private $command;

    public function setUp(): void
    {
        $this->collection = new CommandCollection();
        $this->command    = $this->prophesize(AbstractCommand::class);
    }

    public function testRegisterCommandThrowsExceptionWithEmptyCommandName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->collection->registerCommand($this->command->reveal(), '');
    }

    public function testRegisterCommandThrowsExceptionWhenAlreadyRegisteredWithName(): void
    {
        $this->collection->registerCommand($this->command->reveal(), 'test');
        $this->expectException(\InvalidArgumentException::class);
        $this->collection->registerCommand($this->command->reveal(), 'test');
    }

    public function testRegisterCommandUsesCommandNameWhenNoNamePassed(): void
    {
        $this->command->getName()
                      ->willReturn('testCommand')
                      ->shouldBeCalled();

        $this->collection->registerCommand($this->command->reveal());
    }

    public function testHasCommandReturnsFalseWhenCommandNotRegistered(): void
    {
        $this->assertFalse($this->collection->hasCommand('test'));
    }

    public function testHasCommandReturnsTrueWhenCommandRegistered(): void
    {
        $this->collection->registerCommand($this->command->reveal(), 'test');
        $this->assertTrue($this->collection->hasCommand('test'));
    }

    public function testRunCommandThrowsExceptionWhenRunningNonRegisteredCommand(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->collection->runCommand('test');
    }

    public function testRunCommandReturnsCommandResultCodeWhenComplete(): void
    {
        $this->command->execute()->willReturn(0);
        $this->collection->registerCommand($this->command->reveal(), 'test');
        $this->assertEquals(0, $this->collection->runCommand('test'));
    }

    public function testGetRegisteredCommandNamesReturnsArray(): void
    {
        $this->collection->registerCommand($this->command->reveal(), 'test');
        $this->collection->registerCommand($this->command->reveal(), 'test2');

        $this->assertSame(['test', 'test2'], $this->collection->getRegisteredCommandNames());
    }
}
