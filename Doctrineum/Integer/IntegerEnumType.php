<?php
namespace Doctrineum\Integer;

use Doctrineum\Scalar\EnumType;

/**
 * Class EnumType
 * @package Doctrineum
 *
 * @method static IntegerEnumType getType($name),
 * @see Type::getType
 */
class IntegerEnumType extends EnumType
{
    use IntegerEnumTypeTrait;

    const INTEGER_ENUM = 'integer_enum';

    /**
     * @see \Doctrineum\Scalar\EnumType::convertToPHPValue for usage
     *
     * @param string $enumValue
     * @return IntegerEnum
     */
    protected function convertToEnum($enumValue)
    {
        if (!is_int($enumValue)) {
            throw new Exceptions\UnexpectedValueToEnum(
                'Unexpected value to convert. Expected integer, got ' . gettype($enumValue)
            );
        }

        $enumClass = static::getEnumClass($enumValue);
        /** @var IntegerEnum $enumClass */
        return $enumClass::getEnum($enumValue);
    }

    /**
     * @return string
     */
    protected static function getDefaultEnumClass()
    {
        return IntegerEnum::class;
    }
}
