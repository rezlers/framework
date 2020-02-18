<?php


namespace App\Middleware;


use Kernel\MiddlewareHandler\MiddlewareInterface;
use Kernel\Request\Request;
use function Kernel\Helpers\redirect;

class AuthenticationCheckMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, \Closure $next)
    {
        session_start();
        if ($_SESSION['authentication'] == true)
            return $next($request);
        $_SESSION['errorMessage'] = "You didn't authenticate";
        return redirect('/auth');
    }
}