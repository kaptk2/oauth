<?php

namespace App\Tenancy;

use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Spatie\Multitenancy\Models\Tenant;

class SwitchFortifyRoutesTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(Tenant $tenant): void
    {
        $this->setFortifyDomainConfiguration($tenant->getDomain());
    }

    public function forgetCurrent(): void
    {
        Auth::logout();

        config([
            'fortify.domain' => config('app.domain'),
        ]);
    }

    protected function setFortifyDomainConfiguration(?string $tenantDomain)
    {
        config([
            'fortify.domain' => $tenantDomain,
        ]);
    }
}
