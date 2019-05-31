<?php

namespace audunru\FikenClient;

use FikenClient;
use Illuminate\Support\ServiceProvider;

class FikenClientServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->singleton(FikenClient::class, function ($app) {
            return new FikenClient();
        });
    }
}
