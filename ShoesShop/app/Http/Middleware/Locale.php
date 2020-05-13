<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
class Locale
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
       
        if (Session::has('website_language')){
            App::setLocale(Session::get('website_language'));
        }
       
        return $next($request);
    }
}
