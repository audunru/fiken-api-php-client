<?php

namespace audunru\FikenClient\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\Dotenv\Dotenv;

abstract class TestCase extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env.testing');
    }
}
