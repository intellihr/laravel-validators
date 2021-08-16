<?php

declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class MinChecked extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'min_checked';

    /**
     * @var string
     */
    public static $message = ':attribute requires a minimum of :min checked options';

    public function validateMinChecked(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minChecked = $parameters[0];
        $valid = 0;

        foreach ($value as $checkbox) {
            if ((bool) $checkbox) {
                $valid++;
            }
        }

        return $valid >= $minChecked;
    }

    public function replaceMinChecked(
        $message,
        $attribute,
        $rule,
        array $parameters
    ): string {
        return \str_replace(':min', $parameters[0], $message);
    }
}
