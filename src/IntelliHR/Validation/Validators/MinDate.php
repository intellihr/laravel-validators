<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;
use InvalidArgumentException;

class MinDate extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'min_date';

    /**
     * @var string
     */
    public static $message = ':attribute must be after :min_date';

    public function validateMinDate(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);
        $format = $parameters[1] ?? null;

        $minDate = $this->getDateForParameter($parameters[0], $format);
        $date = $this->getDateForParameter($value, $format);

        if ($minDate === null) {
            throw new InvalidArgumentException('Invalid min date parameter provided: ' . $parameters[0]);
        }

        if ($date === null) {
            return true;
        }

        return $date->gte($minDate);
    }

    public function replaceMinDate(
        string $message,
        string $attribute,
        string $rule,
        array $parameters
    ): string {
        return \str_replace(':min_date', $parameters[0], $message);
    }
}
