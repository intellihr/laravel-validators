<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\LessThan;

class LessThanTest extends BaseTestCase
{
    /**
     * @var LessThan
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new LessThan();
    }

    public function testOneIsLessThanTen(): void
    {
        $valid = $this->validator->validateLessThan(
            'number',
            1,
            [
                10,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testTenIsntLessThanOne(): void
    {
        $valid = $this->validator->validateLessThan(
            'number',
            10,
            [
                1,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testOneIsLessThanIndexedParameter(): void
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 10,
        ]);

        $valid = $this->validator->validateLessThan(
            'number',
            1,
            [
                'something',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testTenIsntLessThanIndexedParameter(): void
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 1,
        ]);

        $valid = $this->validator->validateLessThan(
            'number',
            10,
            [
                'something',
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateLessThan(
            'size',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = 10;
        $expected = 'size must be less than ' . $replacement;
        $string = 'size must be less than :less_than';

        $message = $this->validator->replaceLessThan($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }
}
