<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class OAuthAllowedDomain extends Model
{
    use UsesLandlordConnection;

    protected $guarded = ['id'];

    public function OAuthProvider()
    {
        return $this->belongsTo(OAuthProvider::class);
    }
}
