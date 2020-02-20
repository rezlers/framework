<?php


namespace App\Middleware;


use App\Model\Implementations\User;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\MiddlewareHandler\MiddlewareInterface;
use Kernel\Request\Request;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;

class CheckUrlLoginMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, \Closure $next)
    {
        session_start();
        try {
            if (isset($_SESSION['userId'])) {
                $user = User::getById($_SESSION['userId']);
                if ($request->getPath() == '/account')
                    return redirect('/' . $user->getLogin());
                elseif ($request->getPath() == '/account/' . $request->getParam('action')) {
                    if ($request->getHttpMethod() == 'POST')
                        return $next($request);
                    return redirect('/' . $user->getLogin() . '/' . $request->getParam('action'));
                }
                elseif ($user->getLogin() != $request->getUrlParams()['login'])
                    return abort(404);
            }
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
        return $next($request);
    }
}