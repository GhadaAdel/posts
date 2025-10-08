<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TokenService
{
    public function createRefreshToken(User $user): string
    {
        $plainToken = Str::random(64);

        $user->refreshTokens()->create([
            'token' => hash('sha256', $plainToken),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return $plainToken;
    }
}
