<?php

namespace Laralife\Auth\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Authorize
{
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next)
    {

        $ability = $request->method() . '|' . $request->route()->uri;

        $this->authorize($ability);

        return $next($request);
    }
}
