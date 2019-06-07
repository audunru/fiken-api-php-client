<?php

namespace audunru\FikenClient\Tests;

use Illuminate\Container\Container as Container;
use Illuminate\Support\Facades\Facade as Facade;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function __construct()
    {
        parent::__construct();

        /**
         * Setup a new app instance container.
         *
         * @var Illuminate\Container\Container
         */
        $app = new Container();
        $app->singleton('app', 'Illuminate\Container\Container');
        $app->singleton('audunru\FikenClient\FikenClient');

        /*
        * Set $app as FacadeApplication handler
        */
        Facade::setFacadeApplication($app);
    }
}
