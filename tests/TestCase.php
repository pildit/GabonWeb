<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static function assertManyNotEmpty($keys, $array)
    {
        foreach ($keys as $key)
        {
            self::assertNotEmpty($array[$key]);
        }
    }
}
