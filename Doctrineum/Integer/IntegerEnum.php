<?php
namespace Doctrineum\Integer;

use Doctrineum\Scalar\ScalarEnum;
use Granam\Integer\Tools\ToInteger;

/**
 * @method static IntegerEnum getEnum($value)
 * @method int getValue()
 */
class IntegerEnum extends ScalarEnum implements IntegerEnumInterface
{

    /**
     * Overloading parent @see \Doctrineum\Scalar\EnumTrait::convertToEnumFinalValue
     * @param mixed $enumValue
     * @return int
     * @throws \Doctrineum\Integer\Exceptions\UnexpectedValueToConvert
     */
    protected static function convertToEnumFinalValue($enumValue)
    {
        try {
            return ToInteger::toInteger($enumValue, true /* strict */);
        } catch (\Granam\Integer\Tools\Exceptions\WrongParameterType $exception) {
            // wrapping the exception by local one
            throw new Exceptions\UnexpectedValueToConvert($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}
