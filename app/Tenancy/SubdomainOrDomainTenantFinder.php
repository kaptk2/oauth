<?php

namespace App\Tenancy;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class SubdomainOrDomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request):?Tenant
    {
        $host = $request->getHost();

        if (Str::contains($host, config('app.domain'))) {
            // Using a sub-domain
            $subdomain = Arr::first(explode('.', $host));

            return $this->getTenantModel()::whereName($subdomain)->first();
        }

        $domain = Domain::where('name', $host)->first();

        return $this->getTenantModel()::find($domain?->account_id);
    }

}
