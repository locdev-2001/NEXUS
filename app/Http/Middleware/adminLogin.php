<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
        return $next($request);
        }
            // Người dùng không đăng nhập bằng guard 'admin'
            // Thực hiện các thao tác khác ở đây
            return redirect('/admin/login');
    }
}
