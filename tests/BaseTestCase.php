<?php

namespace IntelliHR\Tests\Validation;

use Illuminate\Validation\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var Validator
     */
    protected $laravelValidator;

    protected function setUp()
    {
        $this->laravelValidator = Mockery::mock(Validator::class)
            ->makePartial()->shouldAllowMockingProtectedMethods();

        parent::setUp();
    }

    protected function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }
}
