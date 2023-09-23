<?php

namespace Waka\Wakapi\Classes\Middleware;

use Closure;

class AddCsrfToken
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Ajoutez le token CSRF à l'en-tête de la réponse
        $response->headers->set('X-CSRF-TOKEN', csrf_token());
        //trace_log($response->headers);

        return $response;
    }
}