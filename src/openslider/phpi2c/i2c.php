<?php

namespace OpenSlider\PHPI2C;

use RuntimeException;

class i2c
{
    const MODE_SINGLE_VALUE = 'b';

    const MODE_WORD = 'w';

    /** @var string */
    private $bus;

    /** @var string */
    private $chipAddress;

    /**
     * i2c constructor.
     *
     * @param int $bus
     * @param int $chipAddress
     */
    public function __construct(int $bus, int $chipAddress)
    {
        $this->bus = $bus;
        $this->chipAddress = $chipAddress;
    }

    /**
     * @param int    $dataAddress
     * @param string $mode
     *
     * @return string
     */
    public function get(int $dataAddress, string $mode = self::MODE_SINGLE_VALUE) : string
    {
        $command = 'i2cget -y ' . (
                escapeshellarg($this->bus) . ' ' .
                escapeshellarg($this->chipAddress) . ' ' .
                escapeshellarg($dataAddress) . ' '
            ) . $mode;

        return base_convert($this->execute($command), 16, 10);
    }

    /**
     * @param int    $dataAddress
     * @param int    $value
     * @param string $mode
     */
    public function set(int $dataAddress, int $value, string $mode = self::MODE_SINGLE_VALUE) : void
    {
        $command = 'i2cset -y ' . (
                escapeshellarg($this->bus) . ' ' .
                escapeshellarg($this->chipAddress) . ' ' .
                escapeshellarg($dataAddress) . ' ' .
                escapeshellarg($value) . ' '
            ) . $mode;

        $this->execute($command);
    }

    /**
     * @param int $dataAddress
     * @param int $value
     */
    public function setWord(int $dataAddress, int $value) : void
    {
        $this->set($dataAddress, $value, self::MODE_WORD);
    }

    /**
     * @param int $dataAddress
     *
     * @return int
     */
    public function getWord(int $dataAddress) : int
    {
        return $this->get($dataAddress, self::MODE_WORD);
    }

    /**
     * @param $command
     *
     * @return string
     */
    private function execute($command) : string
    {
        $result = shell_exec($command . ' 2>&1');

        if (strncmp($result, 'Error:', 6) === 0) {
            throw new RuntimeException($result);
        }

        return $result;
    }
}

