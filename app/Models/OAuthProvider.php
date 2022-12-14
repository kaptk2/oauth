<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class OAuthProvider extends Model
{
    use HasFactory, UsesLandlordConnection;

    protected $guarded = ['id'];

    public function oAuthAllowedDomains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OAuthAllowedDomain::class);
    }
}
