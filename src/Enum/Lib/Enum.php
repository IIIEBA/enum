<?php

namespace Enum\Lib;

use Enum\Lib\Exception\EnumException;

/**
 * Class Enum
 * @package Enum\Lib
 */
abstract class Enum
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $key;

    /**
     * Create enum object
     * @param $value
     * @throws EnumException
     */
    public function __construct($value)
    {
        if(!is_scalar($value)) {
            throw new \InvalidArgumentException('Only scalar types are allowed for value');
        }

        $reflection = new \ReflectionClass($this);
        $constants  = $reflection->getConstants();

        if (count($constants) === 0) {
            throw new EnumException('You must set at least one constant to use Enum object');
        }

        if (!in_array($value, array_values($constants))) {
            throw new \InvalidArgumentException('Not allowed enum value was given');
        }

        $this->value = $value;
        $this->key = array_flip($constants)[$value];
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
