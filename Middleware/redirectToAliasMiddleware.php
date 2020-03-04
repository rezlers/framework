<?php


namespace App\Middleware;


use App\Model\Implementations\User;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\MiddlewareHandler\MiddlewareInterface;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;

class redirectToAliasMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return ResponseInterface
     * @throws ModelException
     */
    public function handle(Request $request, \Closure $next)
    {
        $urlParts = explode('/', $request->getPath());
        $urlParts[0] = User::getById($_SESSION['userId']);
        return redirect(implode('/', $urlParts));
    }

}