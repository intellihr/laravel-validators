<?php
declare(strict_types=1);

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class MaxWords extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'max_words';

    /**
     * @var string
     */
    public static $message = ':attribute must have no more than :max_words words';

    public function validateMaxWords(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minWords = $parameters[0];
        $wordCount = \str_word_count($value);

        return $wordCount <= $minWords;
    }

    public function replaceMaxWords(
        $message,
        $attribute,
        $rule,
        array $parameters
    ): string {
        return \str_replace(':max_words', $parameters[0], $message);
    }
}
