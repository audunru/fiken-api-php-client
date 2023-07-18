<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\User;
use audunru\FikenClient\Tests\TestCase;

class UserTest extends TestCase
{
    public function testItCreatesAUser()
    {
        $user = new User();

        $this->assertInstanceOf(
            User::class,
            $user
        );
    }
}
