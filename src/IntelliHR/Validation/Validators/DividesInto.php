<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class DividesInto extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'divides_into';

    /**
     * @var string
     */
    public static $message = ':attribute is not a divisor';

    public function validateDividesInto(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);

        $value = (float) $value;

        if ($value === 0.0) {
            return false;
        }

        $data = $validator->getData();

        $start = 0;
        $end = $this->getNumber($parameters[0], $data);

        if (\count($parameters) > 1) {
            $start = $this->getNumber($parameters[1], $data);
        }

        $into = ($end - $start) / $value;

        return \floor($into) === $into;
    }

    private function getNumber($parameter, array $data): int
    {
        if (\is_numeric($parameter)) {
            return \intval($parameter, 10);
        }

        return \intval($data[$parameter], 10);
    }
}
