<?php

namespace Tests;

use GenTux\Jwt\JwtToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\User\Entities\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $keys
     * @param $array
     */
    public static function assertManyNotEmpty($keys, $array)
    {
        foreach ($keys as $key)
        {
            self::assertNotEmpty($array[$key]);
        }
    }

    /**
     * @param $keys
     * @param $array
     */
    public static function assertArrayNotHasKeys($keys, $array)
    {
        foreach($keys as $key)
        {
            self::assertArrayNotHasKey($key, $array);
        }
    }

    /**
     * @param Model $expected
     * @param array $actual
     * @param $keys
     */
    public static function assertMultipleEquals(Model $expected, array $actual, $keys)
    {
        foreach ($keys as $key)
        {
            self::assertEquals($expected->{$key}, $actual[$key]);
        }
    }

    /**
     * @return mixed
     */
    public function generateJwtToken()
    {
        return app(JwtToken::class)->createToken(factory(User::class)->create())->token();
    }
}
