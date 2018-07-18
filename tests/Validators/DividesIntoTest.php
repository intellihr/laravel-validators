<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\DividesInto;
use Mockery;

class DividesIntoTest extends BaseTestCase
{
    /**
     * @var DividesInto
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new DividesInto();
    }

    /**
     *
     */
    public function testValidate()
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

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testNonZeroOffset()
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

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testNonDivisibleStep()
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

        $this->assertEquals(false, $valid);
    }

    /**
     *
     */
    public function testTextBasedEnd()
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

        $this->assertEquals(true, $valid);
    }

    public function testDecimalStep()
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

    /**
     *
     */
    public function testThatInsufficientParametersThrowException()
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
