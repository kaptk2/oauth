<?php

namespace App\Tenancy;

use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\URL;

class SwitchUrlTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(Tenant $tenant): void
    {
        if (config('app.env') === 'testing') {
            return;
        }

        URL::formatHostUsing(function () use ($tenant) {
            return $tenant->getDomain();
        });

        config([
            'app.url' => $tenant->getDomain(),
        ]);
    }

    public function forgetCurrent(): void
    {
        URL::formatHostUsing(function () {
            return config('app.url');
        });

        config([
            'app.url' => null,
        ]);
    }
}
