<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class GreaterThan extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'greater_than';

    /**
     * @var string
     */
    public static $message = ':attribute must be greater than :greater_than';

    public function validateGreaterThan(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);

        $greaterThan = $parameters[0];

        if (\is_numeric($greaterThan)) {
            return $value > $greaterThan;
        }

        if (\is_string($greaterThan) && \array_key_exists($greaterThan, $validator->getData())) {
            $otherField = $validator->getData()[$greaterThan];

            return $value > $otherField;
        }

        return false;
    }

    public function replaceGreaterThan(
        $message,
        $attribute,
        $rule,
        array $parameters
    ): string {
        return \str_replace(':greater_than', $parameters[0], $message);
    }
}
