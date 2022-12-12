<?php

namespace App\Providers;

use App\SessionHandlers\CustomSessionHandler;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Session::extend('tenant-aware', function ($app) {
            return new CustomSessionHandler(
                $app->db->connection('landlord'),
                config('session.table'),
                config('session.lifetime'),
                $app
            );
        });
    }
}
