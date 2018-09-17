<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class LegacyDateFormat extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'legacy_date_format';

    /**
     * @var string
     */
    public static $message = ':attribute has an invalid date format';

    public function validateLegacyDateFormat(
        $attribute,
        $value,
        $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, 'date_format');

        if (!\is_string($value) && !\is_numeric($value)) {
            return false;
        }

        $parsed = \date_parse_from_format($parameters[0], $value);

        return $parsed['error_count'] === 0 && $parsed['warning_count'] === 0;
    }
}
