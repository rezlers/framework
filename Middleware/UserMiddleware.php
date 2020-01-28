<?php


namespace App;


use http\Env\Request;
use Closure;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // This method has to be in middleware classes
    }
}