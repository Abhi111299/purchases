<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if(collect($request->route()->middleware())->contains('api')){
            return route('unauthenticated-api');
        }
        else if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
