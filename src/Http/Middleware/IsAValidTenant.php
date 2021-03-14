<?php

namespace Benborla\Hydra\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;

final class IsAValidTenant
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! is_valid_url()) {
            abort(404);
        }

        return $next($request);
    }
}
