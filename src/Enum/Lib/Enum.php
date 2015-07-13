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
    private static $list = [];

    /**
     * Create enum object
     * @param string|int $value
     * @throws EnumException
     */
    public function __construct($value)
    {
        if (!is_string($value) && !is_int($value)) {
            throw new \InvalidArgumentException(
                "Only string or int types are allowed for value in [" . get_called_class() . "]"
            );
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
        $className  = get_called_class();
        $reflection = new \ReflectionClass($className);

        $list = $reflection->getConstants();
        if (empty($list)) {
            throw new EnumException(
                "You must set at least one constant to use Enum object in class [" . get_called_class() . "]"
            );
        }

        self::$list[$className] = [
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
        $className = get_called_class();
        if (!isset(self::$list[$className])) {
            self::initList();
        }

        return self::$list[$className]['values'];
    }

    /**
     * Check value with Enum constants list
     * @param string|int $value Any allowed scalar value
     * @return bool
     */
    public static function isValid($value)
    {
        if (!is_string($value) && !is_int($value)) {
            throw new \InvalidArgumentException(
                "Only string or int types are allowed for value in class [" . get_called_class() . "]"
            );
        }

        if (!in_array($value, self::getList(), true)) {
            throw new \InvalidArgumentException(
                "Not allowed enum value [{$value}] was given to class [" . get_called_class() . "]"
            );
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
