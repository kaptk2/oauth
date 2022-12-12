<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Models\Tenant;

class Account extends Tenant
{
    use UsesMultitenancyConfig;

    protected $casts = [
        'database' => 'json'
    ];

    protected $guarded = ['id'];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::slug($value),
        );
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function oAuthProviders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function getDomain()
    {
        $domain = Domain::where('account_id', $this->id)->first();

        if (! Str::contains($domain->name, '.')) {
            // subdomain found append on the default domain
            return $domain->name.'.'.config('app.domain');
        }

        return 'http://'.$domain->name;
    }
}
