<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\User;
use audunru\FikenClient\Tests\TestCase;

class UserTest extends TestCase
{
    public function test_it_creates_a_user()
    {
        $user = new User();

        $this->assertInstanceOf(
            User::class,
            $user
        );
    }
}
