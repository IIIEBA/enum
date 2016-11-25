<?php

namespace Tests\Enum\Lib;

use Enum\Lib\Enum;
use PhpUnitPlus\Lib\Component\InputDataChecker;
use PhpUnitPlus\Lib\Util\Custom\ManualInput;

/**
 * Class EnumTest
 * @package Tests\Enum\Lib
 */
class EnumTest extends \PHPUnit_Framework_TestCase
{
    use InputDataChecker;

    public function testConstruct()
    {
        $this->checkInputData(
            [new ManualInput([1, 'two', null])],
            function ($value) {
                new Foo($value);
            }
        );
    }

    public function testConstructorForValidTypesButInvalidValues()
    {
        $values = [2, 'one', null];

        foreach ($values as $value) {
            try {
                new Foo($value);
                $this->fail("Test didn`t fall down on incorrect value - {$value}");
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true);
            }
        }
    }

    public function testIsValid()
    {
        $this->checkInputData(
            [new ManualInput([1, 'two'])],
            function ($value) {
                Foo::isValid($value);
            }
        );
    }

    public function testIsValidForValidTypesButInvalidValues()
    {
        $values = [3, 'one'];

        foreach ($values as $value) {
            try {
                Foo::isValid($value);
                $this->fail("Test didn`t fall down on incorrect value - {$value}");
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true);
            }
        }
    }

    public function testGetList()
    {
        $list   = Foo::getList();
        $foo    = new Foo(1);

        $reflectionFoo = new \ReflectionClass($foo);

        $this->assertSame($reflectionFoo->getConstants(), $foo->getList());
        $this->assertEquals($list, $foo->getList());
    }

    public function testIsEquals()
    {
        $foo = new Foo(Foo::ONE);

        $this->assertTrue($foo->isEquals(Foo::ONE));
        $this->assertFalse($foo->isEquals(Foo::TWO));
    }

    public function testGetValue()
    {
        $value  = 'two';
        $foo    = new Foo($value);

        $this->assertEquals($value, $foo->getValue());
    }

    public function testGetKey()
    {
        $value  = 1;
        $foo    = new Foo($value);

        $this->assertEquals('ONE', $foo->getKey());
    }
}

class Foo extends Enum
{
    const ONE = 1;
    const TWO = 'two';
    const THREE = null;
}
