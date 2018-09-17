<?php
declare(strict_types=1);

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\LegacyDateFormat;

class LegacyDateFormatTest extends BaseTestCase
{
    /**
     * @var LegacyDateFormat
     */
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new LegacyDateFormat();
    }

    /**
     * @dataProvider data
     */
    public function testValidatesAsExpected(
        string $attribute,
        string $value,
        array $parameters,
        bool $expected
    ): void {
        $result = $this
            ->validator
            ->validateLegacyDateFormat(
                $attribute,
                $value,
                $parameters,
                $this->laravelValidator
            );

        $this->assertSame($expected, $result);
    }

    public function data(): array
    {
        return [
            [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00:00+00',
                'parameters' => [
                    'Y-m-d H:i:sO',
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '1997-04-23 14:00:00+10',
                'parameters' => [
                    'Y-m-d H:i:sO',
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00',
                'parameters' => [
                    'Y-m-d H:i',
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01',
                'parameters' => [
                    'Y-m-d',
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00:00',
                'parameters' => [
                    'Y-m-d H:i:sO',
                ],
                'expected' => false,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00',
                'parameters' => [
                    'Y-m-d H:i:sO',
                ],
                'expected' => false,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01',
                'parameters' => [
                    'Y-m-d H:i:sO',
                ],
                'expected' => false,
            ],
        ];
    }
}
