<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckJsonIsValid
{
    public function handle($request, Closure $next)
    {
        if ($request->isJson()) {
            // Attempt to decode payload
            json_decode($request->getContent());

            if (json_last_error() != JSON_ERROR_NONE) {
                // There was an error
                throw new \Exception('Bad JSON received', Response::HTTP_BAD_REQUEST);
            }
        }

        // JSON decoding didn’t throw error; continue
        return $next($request);
    }
}
