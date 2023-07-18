<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Exceptions\AuthenticationFailedException;
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\User;
use audunru\FikenClient\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testItThrowsAnExceptionWhenNoUsernameOrPasswordIsSet()
    {
        $client = new FikenClient();

        $this->expectException(AuthenticationFailedException::class);

        $client->user();
    }

    /**
     * @group dangerous
     */
    public function testItCanAuthenticateWithMethod()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $user = $client->user();

        $this->assertInstanceOf(User::class, $user);
    }
}
