<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Candidate;

class Installed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $candidate = Candidate::all()->first();
        if (!$candidate) {
            return redirect()->route('setup');
        }
        return $next($request);
    }
}
