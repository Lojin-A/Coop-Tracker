<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AuthApi
{
    public function stats()
    {
        $token = $this->token();

        if (! $token) {
            return null;
        }

        try {
            $response = Http::timeout(3)
                ->withToken($token)
                ->get(config('services.auth.url') . '/api/stats/placements');

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->status() === 401) {
                Cache::forget('auth_api_token');
            }
        } catch (\Exception $e) {
            // the auth service is not running
        }

        return null;
    }

    private function token()
    {
        $token = Cache::get('auth_api_token');

        if ($token) {
            return $token;
        }

        try {
            $response = Http::timeout(3)
                ->post(config('services.auth.url') . '/api/login', [
                    'email'    => config('services.auth.email'),
                    'password' => config('services.auth.password'),
                ]);

            if ($response->successful()) {
                $token = $response->json('token');
                Cache::put('auth_api_token', $token, 1800);

                return $token;
            }
        } catch (\Exception $e) {
            // login failed
        }

        return null;
    }
}