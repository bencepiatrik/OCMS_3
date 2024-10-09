<?php

namespace Ben\Slack\Middleware;

use Closure;
use Ben\Slack\Services\AuthService;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        $user = AuthService::getAuthenticatedUser($token);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /* REVIEW - To ako si si to poriešil cez tohto 'authenticated_user' je celkom elegantné riešenie, ale pridal by som niekde funkciu ktorá ho získa z requestu
        lebo teraz sa ti tento 'authenticated_user' string opakuje v controlleroch */
        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
