<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $key = $request->get('api_key') ?? $request->header('x-api-key');

        abort_if(!$key, 401, 'No API key provided');

        $user = User::where('api_key', $key)->first();

        abort_if(!$user, 401, 'Invalid API key');

        Auth::setUser($user);

        return $next($request);

    }
}
