<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class DangTinMiddleware
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
        
        if(Auth::check()){
            $user = Auth::user();
                if($user->right == 2)
                    return $next($request);
                else
                    return redirect('/user/register-owner')->with('thongbao','Vui lòng đăng ký thông tin Người cho thuê');
        }
        else
            return redirect('/user/login');
    }
}
