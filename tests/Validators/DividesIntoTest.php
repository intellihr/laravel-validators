<?php
declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\DividesInto;

class DividesIntoTest extends BaseTestCase
{
    /**
     * @var DividesInto
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new DividesInto();
    }

    public function testValidate(): void
    {
        $this->laravelValidator->shouldReceive('getData')->once()->andReturn([]);

        $valid = $this->validator->validateDividesInto(
            'size',
            10,
            [
                100,
                0,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testNonZeroOffset(): void
    {
        $this->laravelValidator->shouldReceive('getData')->once()->andReturn([]);

        $valid = $this->validator->validateDividesInto(
            'size',
            25,
            [
                100,
                50,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testNonDivisibleStep(): void
    {
        $this->laravelValidator->shouldReceive('getData')->once()->andReturn([]);

        $valid = $this->validator->validateDividesInto(
            'size',
            66,
            [
                100,
                0,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testTextBasedEnd(): void
    {
        $this->laravelValidator->shouldReceive('getData')->once()->andReturn([
            'start' => '20',
        ]);

        $valid = $this->validator->validateDividesInto(
            'size',
            2,
            [
                100,
                'start',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testDecimalStep(): void
    {
        $this
            ->laravelValidator
            ->shouldReceive('getData')
            ->once()
            ->andReturn([]);

        $valid = $this
            ->validator
            ->validateDividesInto(
                'size',
                '0.25',
                [
                    1,
                    100,
                ],
                $this->laravelValidator
            );

        $this->assertTrue($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateDividesInto(
            'size',
            1,
            [],
            $this->laravelValidator
        );
    }
}
