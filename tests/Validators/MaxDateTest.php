<?php

declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use DateInterval;
use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MaxDate;

class MaxDateTest extends BaseTestCase
{
    /**
     * @var MaxDate
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new MaxDate();
    }

    public function testNowIsBeforeNextWeek(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d');
        $future = (new \DateTimeImmutable())->add(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMaxDate(
            'date',
            $now,
            [
                $future,
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }

    public function testNowIsntBeforeLastWeek(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d');
        $past = (new \DateTimeImmutable())->sub(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMaxDate(
            'date',
            $now,
            [
                $past,
            ],
            $this->laravelValidator
        );

        $this->assertFalse($valid);
    }

    public function testThatInsufficientParametersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMaxDate(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced(): void
    {
        $replacement = '2100-01-01';
        $expected = 'date must be before ' . $replacement;
        $string = 'date must be before :max_date';

        $message = $this->validator->replaceMaxDate($string, '', '', [$replacement]);

        $this->assertSame($expected, $message);
    }

    public function testThatInvalidParameterDateFails(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMaxDate(
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
        $valid = $this->validator->validateMaxDate(
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
        $valid = $this->validator->validateMaxDate(
            'date',
            '2007-07-07',
            [
                '09/09/2009',
                'd/m/Y',
            ],
            $this->laravelValidator
        );

        $this->assertTrue($valid);
    }
}
