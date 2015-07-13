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
     * @var array
     */
    private static $list;

    /**
     * Create enum object
     * @param string|int $value
     * @throws EnumException
     */
    public function __construct($value)
    {
        if (!is_string($value) && !is_int($value)) {
            throw new \InvalidArgumentException('Only string or int types are allowed for value');
        }

        $this->isValid($value);

        $this->value    = $value;
        $this->key      = self::$list['keys'][$value];
    }

    /**
     * Init constants list for static access for them
     */
    private static function initList()
    {
        $reflection = new \ReflectionClass(get_called_class());

        $list = $reflection->getConstants();
        if (empty($list)) {
            throw new EnumException('You must set at least one constant to use Enum object');
        }

        self::$list = [
            'values'    => $list,
            'keys'      => array_flip($list),
        ];
    }

    /**
     * Return constant list of current class
     * @return array
     */
    public static function getList()
    {
        if (self::$list === null) {
            self::initList();
        }

        return self::$list['values'];
    }

    /**
     * Check value with Enum constants list
     * @param string|int $value Any allowed scalar value
     * @return bool
     */
    public static function isValid($value)
    {
        if (!is_string($value) && !is_int($value)) {
            throw new \InvalidArgumentException('Only string or int types are allowed for value');
        }

        if (!in_array($value, self::getList(), true)) {
            throw new \InvalidArgumentException('Not allowed enum value was given');
        }

        return true;
    }

    /**
     * @return string|int
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
