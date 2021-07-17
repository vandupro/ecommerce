<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
class login_manage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    
    {    $Cookie_user = Cookie::get('admin_login_remember'); 
        $session_user = session('admin_login');
        if(isset($Cookie_user)&& !empty($Cookie_user)){ // check isset cookie
         $check_user= DB::table("users")->where('remember_token',$Cookie_user)->get();
         if(!isset($Cookie_user)|| empty($Cookie_user)){

            return redirect('/auth/login');
         }
        }
       elseif(!isset($session_user)|| empty($session_user)){ // check isset session
         //   dd("session_user");
            return redirect('/auth/login');
        }
       // dd($value->remember_token);
        return $next($request);
    }
}
