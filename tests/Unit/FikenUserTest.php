<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\FikenUser;
use audunru\FikenClient\Tests\TestCase;

class FikenUserTest extends TestCase
{
    public function test_it_creates_a_user()
    {
        $user = new FikenUser();

        $this->assertInstanceOf(
            FikenUser::class,
            $user
        );
    }
}
