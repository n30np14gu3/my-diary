<?php

namespace App\Http\Middleware;

use App\Helpers\UserHelper;
use Closure;
use Illuminate\Http\Request;

class AuthMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!UserHelper::GetUser($request))
            return redirect('/');
        return $next($request);
    }
}
