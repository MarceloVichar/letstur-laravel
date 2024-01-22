<?php

namespace App\Http\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        $message = 'Forbidden Route. ';
        $message .= "This resource was meant for '".$this->getUserTypeLabel($roles[0])."' and ";
        $message .= "you are authenticated as '".$this->getUserTypeLabel($request->user()->getRoleNames()[0])."'.";

        return abort(403, $message);
    }

    private function getUserTypeLabel($userType)
    {
        return $userType;
    }
}
