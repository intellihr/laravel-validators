<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class MinWords extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'min_words';

    /**
     * @var string
     */
    public static $message = ':attribute must have at least :min_words words';

    public function validateMinWords(
        string $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minWords = $parameters[0];
        $wordCount = \str_word_count($value);

        return $wordCount >= $minWords;
    }

    public function replaceMinWords(
        $message,
        $attribute,
        $rule,
        array $parameters
    ): string {
        return \str_replace(':min_words', $parameters[0], $message);
    }
}
