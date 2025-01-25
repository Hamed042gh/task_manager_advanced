<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class RateLimiterService
{
    public function CheckRateLimiter(string $key)
    {
        Log::info('Rate Limiting Key: ' . $key);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            Log::info('Rate Limiting exceeded for key: ' . $key);
            abort(429, __('auth.too_many_attempts'));
        }
    }

    public function hitLimmit(string $key, int $decaySeconds = 600)
    {
        RateLimiter::hit($key, $decaySeconds);
        Log::info('Rate Limiting hit for key: ' . $key . ' with decay: ' . $decaySeconds);
    }
}
