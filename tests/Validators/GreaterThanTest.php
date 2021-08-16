<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\GreaterThan;

class GreaterThanTest extends BaseTestCase
{
    /**
     * @var GreaterThan
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new GreaterThan();
    }

    public function testTenIsGreaterThanOne(): void
    {
        $valid = $this->validator->validateGreaterThan(
            'number',
            10,
            [
                1,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testOneIsntGreaterThanTen(): void
    {
        $valid = $this->validator->validateGreaterThan(
            'number',
            1,
            [
                10,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testTenIsGreaterThanIndexedParameter(): void
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 1,
        ]);

        $valid = $this->validator->validateGreaterThan(
            'number',
            10,
            [
                'something',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testOneIsntGreaterThanIndexedParameter(): void
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 10,
        ]);

        $valid = $this->validator->validateGreaterThan(
            'number',
            1,
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

        $this->validator->validateGreaterThan(
            'size',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = 1;
        $expected = 'size must be greater than ' . $replacement;
        $string = 'size must be greater than :greater_than';

        $message = $this->validator->replaceGreaterThan($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }
}
