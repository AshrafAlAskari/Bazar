<?php
namespace App\Http\Middleware;
use Auth;
use Closure;
class CheckAdmin
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
        if(!Auth::guard('admin')->check())
            return redirect()->route('dashboard');
        return $next($request);
    }
}
