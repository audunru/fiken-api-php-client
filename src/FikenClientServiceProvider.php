<?php

namespace audunru\FikenClient;

use Illuminate\Support\ServiceProvider;

class FikenClientServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->singleton('audunru\FikenClient\FikenClient');
    }
}
