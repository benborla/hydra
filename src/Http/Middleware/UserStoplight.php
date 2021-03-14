<?php

namespace Benborla\Hydra\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

final class UserStoplight
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $domain = domain();

        if (Nova::check($request) && is_valid_url()) {

            $user = auth()->user();

            // check if the user is accessing the main admin panel
            if (is_main_admin_url()
                && $user->isSuperAdmin
            ) {
                return $this->nextStep($next, $request);
            }

            if ($user->query()
                ->hasChannel(auth()->user(), $domain)
                ->first() || $user->isSuperAdmin
            ) {
                return $this->nextStep($next, $request);
            }
        }

        Auth::logout();
        abort(403);
    }

    private function nextStep($next, $request)
    {
        view()->share('currentChannel', channel());
        return $next($request);
    }

}
