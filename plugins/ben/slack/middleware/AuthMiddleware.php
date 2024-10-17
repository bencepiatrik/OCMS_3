<?php

namespace Ben\Slack\Middleware;

use Closure;
use Ben\Slack\Services\AuthService;

class AuthMiddleware
{
    /**
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $user = AuthService::getAuthenticatedUser($token);

        if (!$user) {
            throw new \Exception('Unauthorized');
        }

        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
