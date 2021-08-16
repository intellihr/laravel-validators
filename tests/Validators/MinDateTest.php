<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use Carbon\Carbon;
use DateInterval;
use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MinDate;

class MinDateTest extends BaseTestCase
{
    /**
     * @var MinDate
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new MinDate();
    }

    public function testNowIsAfterLastWeek(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d');
        $past = (new \DateTimeImmutable())->sub(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMinDate(
            'date',
            $now,
            [
                $past,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testNowIsntAfterNextWeek(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d');
        $future = (new \DateTimeImmutable())->add(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMinDate(
            'date',
            $now,
            [
                $future,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMinDate(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = '2000-01-01';
        $expected = 'date must be after ' . $replacement;
        $string = 'date must be after :min_date';

        $message = $this->validator->replaceMinDate($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }

    public function testThatInvalidParameterDateFails(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMinDate(
            'date',
            '2007-07-07',
            [
                'invalid',
            ],
            $this->laravelValidator
        );
    }

    public function testThatInvalidValueDatePasses(): void
    {
        $valid = $this->validator->validateMinDate(
            'date',
            'invalid',
            [
                '2007-07-07',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testThatParametersCanBeSpecifiedWithFormat(): void
    {
        $valid = $this->validator->validateMinDate(
            'date',
            '2007-07-07',
            [
                '01/01/2001',
                'd/m/Y',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testValidatorShouldValidateAgainstValidCarbonObject(): void
    {
        $valid = $this->validator->validateMinDate(
            'date',
            Carbon::maxValue(),
            [
                Carbon::now()->format('Y-m-d'),
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testValidatorShouldValidateAgainstInvalidCarbonObject(): void
    {
        $valid = $this->validator->validateMinDate(
            'date',
            Carbon::minValue(),
            [
                Carbon::now()->format('Y-m-d'),
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }
}
