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

        /* REVIEW - To ako si si to poriešil cez tohto 'authenticated_user' je celkom elegantné riešenie, ale pridal by som niekde funkciu ktorá ho získa z requestu
        lebo teraz sa ti tento 'authenticated_user' string opakuje v controlleroch */
        // Fix - Pridal som getAuthenticatedUserFromRequest do AuthService, dúfam že si myslel na toto lebo v dokumentacii som to nenašiel

        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
