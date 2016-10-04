<?php
namespace Doctrineum\Tests\Integer;

use Doctrineum\Integer\IntegerEnum;
use Doctrineum\Scalar\ScalarEnumInterface;
use Doctrineum\Tests\Scalar\Helpers\WithToStringTestObject;
use Granam\Integer\IntegerInterface;

class IntegerEnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_integer_enum()
    {
        $enumClass = $this->getEnumClass();
        $instance = $enumClass::getEnum(12345);
        self::assertInstanceOf($enumClass, $instance);
        self::assertInstanceOf(IntegerInterface::class, $instance);
    }

    /**
     * @return \Doctrineum\Integer\IntegerEnum|string
     */
    protected function getEnumClass()
    {
        return IntegerEnum::getClass();
    }

    /**
     * @test
     */
    public function returns_the_same_integer_as_created_with()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum($integer = 12345);
        self::assertSame($integer, $enum->getValue());
        self::assertSame("$integer", (string)$enum);
    }

    /**
     * @test
     */
    public function returns_integer_created_from_string_created_with()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum($stringInteger = '12345');
        self::assertSame((int)$stringInteger, $enum->getValue());
        self::assertSame($stringInteger, (string)$enum);
    }

    /**
     * @test
     */
    public function string_with_integer_and_spaces_is_trimmed_and_accepted()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum('  12 ');
        self::assertSame(12, $enum->getValue());
        self::assertSame('12', (string)$enum);
    }

    /**
     * @test
     */
    public function float_without_decimal_is_its_integer_value()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum(123.0);
        self::assertSame(123, $enum->getValue());
    }

    /**
     * @test
     * @expectedException \Doctrineum\Scalar\Exceptions\UnexpectedValueToEnum
     */
    public function float_with_decimal_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum(12.345);
    }

    /**
     * @test
     */
    public function string_float_without_decimal_is_its_integer_value()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum('123.0');
        self::assertSame(123, $enum->getValue());
    }

    /**
     * @test
     * @expectedException \Doctrineum\Scalar\Exceptions\UnexpectedValueToEnum
     */
    public function string_float_with_decimal_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum('12.345');
    }

    /**
     * @test
     * @expectedException \Doctrineum\Scalar\Exceptions\UnexpectedValueToEnum
     */
    public function string_with_partial_integer_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum('12foo');
    }

    /**
     * @test
     */
    public function object_with_integer_and_to_string_can_be_used()
    {
        $enumClass = $this->getEnumClass();
        $enum = $enumClass::getEnum(new WithToStringTestObject($integer = 12345));
        self::assertInstanceOf(ScalarEnumInterface::class, $enum);
        self::assertSame($integer, $enum->getValue());
        self::assertSame("$integer", (string)$enum);
    }

    /**
     * @test
     * @expectedException \Doctrineum\Scalar\Exceptions\UnexpectedValueToEnum
     */
    public function to_string_object_with_non_numeric_value_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum(new WithToStringTestObject('foo'));
    }

    /**
     * @test
     * @expectedException \Doctrineum\Scalar\Exceptions\UnexpectedValueToEnum
     */
    public function empty_string_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum('');
    }

    /**
     * @test
     * @expectedException \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     */
    public function null_cause_exception()
    {
        $enumClass = $this->getEnumClass();
        $enumClass::getEnum(null);
    }

    /**
     * @test
     */
    public function inherited_enum_with_same_value_lives_in_own_inner_namespace()
    {
        $enumClass = $this->getEnumClass();

        $enum = $enumClass::getEnum($value = 12345);
        self::assertInstanceOf($enumClass, $enum);
        self::assertSame($value, $enum->getValue());
        self::assertSame("$value", (string)$enum);

        $inDifferentNamespace = $this->getInheritedEnum($value);
        self::assertInstanceOf($enumClass, $inDifferentNamespace);
        self::assertSame($enum->getValue(), $inDifferentNamespace->getValue());
        self::assertNotSame($enum, $inDifferentNamespace);
    }

    protected function getInheritedEnum($value)
    {
        return TestInheritedIntegerEnum::getEnum($value);
    }
}

/** inner */
class TestInheritedIntegerEnum extends IntegerEnum
{

}