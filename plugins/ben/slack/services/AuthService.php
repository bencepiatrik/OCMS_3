<?php

namespace Ben\Slack\Services;

use Ben\Slack\Models\User;

class AuthService
{
    public static function getAuthenticatedUser($token)
    {
        return User::where('api_token', $token)->first();
    }
}