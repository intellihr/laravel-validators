<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MinWords;

class MinWordsTest extends BaseTestCase
{
    /**
     * @var MinWords
     */
    protected $validator;

    /**
     * @var string
     */
    private $sentence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new MinWords();
        $this->sentence = 'Lorem ipsum dolor sit amet, 8';
    }

    public function testThatSixWordsAreMoreThenFive(): void
    {
        $valid = $this->validator->validateMinWords(
            'sentence',
            $this->sentence,
            [
                5,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testThatSixWordsAreLessThenTen(): void
    {
        $valid = $this->validator->validateMinWords(
            'sentence',
            $this->sentence,
            [
                10,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMinWords(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = '10';
        $expected = 'sentence must have no more than ' . $replacement . ' words';
        $string = 'sentence must have no more than :min_words words';

        $message = $this->validator->replaceMinWords($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }
}
