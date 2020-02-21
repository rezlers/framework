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
        if ($request->getParam('action') == 'logout') {
            $_SESSION['authentication'] = false;
            unset($_SESSION['userId']);
            return redirect('/auth');
        }
        if ($_SESSION['authentication'] == true) {
            if (in_array($request->getPath(), ['/', '/auth', '/registration']))
                return redirect('/main');
            return $next($request);
        }
        if (in_array($request->getPath(), ['/', '/auth', '/registration']))
            return $next($request);
        elseif ($request->getParam('action') == 'do')
            return $next($request);

        $_SESSION['errorMessage'] = "You didn't authenticate";
        return redirect('/auth');
    }
}