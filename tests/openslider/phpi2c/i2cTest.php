<?php

namespace Tests\Unit\OpenSlider\phpi2c;

use phpmock\phpunit\PHPMock;
use OpenSlider\PHPI2C\i2c;

function shell_exec($cmd) {
    return i2cTest::$functions->shell_exec($cmd);
}

final class i2cTest extends \PHPUnit_Framework_TestCase
{
    use PHPMock;

    const I2C_COMMAND_SET_BYTE = "i2cset -y '%s' '%s' '%s' '%s' b 2>&1";
    const I2C_COMMAND_SET_WORD = "i2cset -y '%s' '%s' '%s' '%s' w 2>&1";
    const I2C_COMMAND_GET_BYTE = "i2cget -y '%s' '%s' '%s' b 2>&1";
    const I2C_COMMAND_GET_WORD = "i2cget -y '%s' '%s' '%s' w 2>&1";

    /** @var i2c */
    private $i2c;

    const BUS = 1;

    const CHIP_ADDRESS = 0x68;

    const TEST_ADDRESS = 0x43;

    const TEST_VALUE = 0x45;

    public function setUp()
    {
        $this->i2c = new i2c(self::BUS, self::CHIP_ADDRESS);
    }

    /** @test */
    public function proper_command_is_executed_when_calling_the_set_method()
    {
        $exec = $this->getFunctionMock('OpenSlider\\PHPI2C', "shell_exec");
        $exec->expects($this->once())
            ->willReturn('')
            ->with(sprintf(self::I2C_COMMAND_SET_BYTE, self::BUS, self::CHIP_ADDRESS, self::TEST_ADDRESS, self::TEST_VALUE)
        );

        $this->i2c->set(self::TEST_ADDRESS, self::TEST_VALUE);
    }

    /** @test */
    public function proper_command_is_executed_when_calling_the_set_word_method()
    {
        $exec = $this->getFunctionMock('OpenSlider\\PHPI2C', "shell_exec");
        $exec->expects($this->once())
            ->willReturn('')
            ->with(sprintf(self::I2C_COMMAND_SET_WORD, self::BUS, self::CHIP_ADDRESS, self::TEST_ADDRESS, self::TEST_VALUE)
            );

        $this->i2c->setWord(self::TEST_ADDRESS, self::TEST_VALUE);
    }

    /** @test */
    public function proper_command_is_executed_when_calling_the_get_method()
    {
        $exec = $this->getFunctionMock('OpenSlider\\PHPI2C', "shell_exec");
        $exec->expects($this->once())
            ->willReturn('')
            ->with(sprintf(self::I2C_COMMAND_GET_BYTE, self::BUS, self::CHIP_ADDRESS, self::TEST_ADDRESS)
            );

        $this->i2c->get(self::TEST_ADDRESS);
    }

    /** @test */
    public function proper_command_is_executed_when_calling_the_get_word_method()
    {
        $exec = $this->getFunctionMock('OpenSlider\\PHPI2C', "shell_exec");
        $exec->expects($this->once())
            ->willReturn('')
            ->with(sprintf(self::I2C_COMMAND_GET_WORD, self::BUS, self::CHIP_ADDRESS, self::TEST_ADDRESS)
            );

        $this->i2c->getWord(self::TEST_ADDRESS);
    }

}