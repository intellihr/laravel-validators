<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\LegacyDateFormat;

class LegacyDateFormatTest extends BaseTestCase
{
    /**
     * @var LegacyDateFormat
     */
    protected $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new LegacyDateFormat();
    }

    /**
     * @dataProvider data
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param bool $expected
     */
    public function testValidatesAsExpected(
        string $attribute,
        string $value,
        array $parameters,
        bool $expected
    ) {
        $result = $this
            ->validator
            ->validateLegacyDateFormat(
                $attribute,
                $value,
                $parameters,
                $this->laravelValidator
            );

        $this->assertEquals($expected, $result);
    }

    public function data(): array
    {
        return [
            [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00:00+00',
                'parameters' => [
                    'Y-m-d H:i:sO'
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '1997-04-23 14:00:00+10',
                'parameters' => [
                    'Y-m-d H:i:sO'
                ],
                'expected' => true,
            ],[
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00',
                'parameters' => [
                    'Y-m-d H:i'
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01',
                'parameters' => [
                    'Y-m-d'
                ],
                'expected' => true,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00:00',
                'parameters' => [
                    'Y-m-d H:i:sO'
                ],
                'expected' => false,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01 00:00',
                'parameters' => [
                    'Y-m-d H:i:sO'
                ],
                'expected' => false,
            ], [
                'attribute' => 'start_date',
                'value' => '2018-01-01',
                'parameters' => [
                    'Y-m-d H:i:sO'
                ],
                'expected' => false,
            ],
        ];
    }
}
