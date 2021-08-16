<?php

declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;
use InvalidArgumentException;

class MaxDate extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'max_date';

    /**
     * @var string
     */
    public static $message = ':attribute must be before :max_date';

    public function validateMaxDate(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);
        $format = $parameters[1] ?? null;

        $maxDate = $this->getDateForParameter($parameters[0], $format);
        $date = $this->getDateForParameter($value, $format);

        if ($maxDate === null) {
            throw new InvalidArgumentException('Invalid max date parameter provided: ' . $parameters[0]);
        }

        if ($date === null) {
            return true;
        }

        return $date->lte($maxDate);
    }

    public function replaceMaxDate(
        string $message,
        string $attribute,
        string $rule,
        array $parameters
    ): string {
        return \str_replace(':max_date', $parameters[0], $message);
    }
}
