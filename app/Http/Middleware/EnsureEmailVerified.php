<?php

namespace App\Http\Middleware;

use App\Contracts\Repositories\AuthenticateRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerified
{
    /**
     * Instantiate a new middleware instance.
     */
    public function __construct(protected AuthenticateRepositoryInterface $authRepository)
    {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🚀 Email verification disabled — always continue.
        return $next($request);
    }
}
