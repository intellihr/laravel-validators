<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

abstract class AbstractValidator
{
    /**
     * @throws InvalidArgumentException
     */
    protected function requireParameterCount(int $count, array $parameters, string $rule): void
    {
        if (\count($parameters) < $count) {
            throw new InvalidArgumentException("Validation rule ${rule} requires at least ${count} parameters.");
        }
    }

    protected function getDateForParameter(
        $parameter,
        string $format = null
    ): ?Carbon {
        if ($parameter instanceof Carbon) {
            return $parameter;
        }

        try {
            $date = ($format !== null)
                ? Carbon::createFromFormat($format, $parameter)
                : new Carbon($parameter);
        } catch (Exception $e) {
            return null;
        }

        if ($date === false) {
            return null;
        }

        return $date;
    }
}
