<?php

namespace App\Http\Middleware;

use App\Contracts\Repositories\AuthenticateRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountActive
{
    /**
     * Instantiate a new middleware instance.
     */
    public function __construct(protected AuthenticateRepositoryInterface $authRepository)
    {}

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
