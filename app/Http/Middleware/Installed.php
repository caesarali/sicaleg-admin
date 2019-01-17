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
        return redirect()->route('setup');
        // $candidate = Candidate::all();
        // if (empty($candidate)) {
        //     return redirect()->route('setup');
        // }
        // return $next($request);
    }
}
