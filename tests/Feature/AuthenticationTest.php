<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Exceptions\AuthenticationFailedException;
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\User;
use audunru\FikenClient\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_it_throws_an_exception_when_no_username_or_password_is_set()
    {
        $client = new FikenClient();

        $this->expectException(AuthenticationFailedException::class);

        $client->user();
    }

    public function test_it_can_authenticate_with_method()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $user = $client->user();

        $this->assertInstanceOf(User::class, $user);
    }
}
