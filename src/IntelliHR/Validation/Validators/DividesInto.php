<?php

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class DividesInto extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'divides_into';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute is not a divisor';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateDividesInto(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $value = \floatval($value);

        if ($value === 0.0) {
            return false;
        }

        $data  = $validator->getData();

        $start = 0;
        $end = $this->getNumber($parameters[0], $data);

        if (count($parameters) > 1) {
            $start = $this->getNumber($parameters[1], $data);
        }

        $into = ($end - $start) / $value;

        return floor($into) === $into;
    }

    /**
     * @param       $parameter
     * @param array $data
     *
     * @return int
     */
    private function getNumber($parameter, array $data)
    {
        if (is_numeric($parameter)) {
            return intval($parameter, 10);
        } else {
            return intval($data[$parameter], 10);
        }
    }
}
