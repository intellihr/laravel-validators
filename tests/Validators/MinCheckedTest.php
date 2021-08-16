<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MinChecked;

class MinCheckedTest extends BaseTestCase
{
    /**
     * @var MinChecked
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new MinChecked();
    }

    /**
     * @dataProvider checkboxData
     */
    public function testThatAtMinAreChecked($totalChecked, array $data): void
    {
        $valid = $this->validator->validateMinChecked(
            'checkbox',
            $data,
            [
                $totalChecked,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    /**
     * @dataProvider checkboxData
     */
    public function testThatAtMinArentChecked($totalChecked, array $data): void
    {
        $valid = $this->validator->validateMinChecked(
            'checkbox',
            $data,
            [
                $totalChecked + 1,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMinChecked(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = '10';
        $expected = 'checkbox requires a minimum of ' . $replacement . ' checked options';
        $string = 'checkbox requires a minimum of :min checked options';

        $message = $this->validator->replaceMinChecked($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }

    public function checkboxData()
    {
        return [
            'one of three checked' => [
                1,
                [
                    1,
                    0,
                    0,
                ],
            ],
            'two of five checked' => [
                2,
                [
                    0,
                    0,
                    1,
                    1,
                    0,
                ],
            ],
            'all four checked' => [
                4,
                [
                    1,
                    1,
                    1,
                    1,
                ],
            ],
        ];
    }
}
