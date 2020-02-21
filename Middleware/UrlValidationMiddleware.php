<?php


namespace App\Middleware;


use App\Model\Implementations\User;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\MiddlewareHandler\MiddlewareInterface;
use Kernel\Request\Request;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;

class UrlValidationMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, \Closure $next)
    {
        session_start();
        try {
            $users = User::all();
            foreach ($users as $user) {
                $loginUrlPart = $request->getParam('login');
                if ($user->getLogin() == $loginUrlPart) {
                    return $next($request);
                }
            }
            return abort(404);
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
    }
}