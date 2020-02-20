<?php


namespace App\controller;


use App\Model\Implementations\Link;
use App\Model\Implementations\User;
use App\Model\UserInterface;
use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\render;

class LinksController implements ControllerInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        session_start();
        try {
            if (isset($_SESSION['userId'])) {
                $user = User::getById($_SESSION['userId']);

                if ($request->getPath() == '/main') {
                    $_SESSION['linkData'] = $this->getLinks($user, 'all');
                    return render('MainPage.php');
                } elseif ($request->getPath() == '/links') {
                    $_SESSION['linkData'] = $this->getLinks($user, 'personal');
                    return render('UserLinks.php');
                }
            }
        } catch (ModelException $exception) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($exception->getMessage());
            return abort(500);
        }
        return App::Response()->setStatusCode(404);
    }

    /**
     * @param UserInterface $user
     * @param string $context
     * @return Link[]|array
     * @throws ModelException
     */
    private function getLinks(UserInterface $user, string $context)
    {
        if ($context == 'all'){
            $links = Link::all();
            foreach ($links as $link) {
                $link->setUser();
            }
            return $links;
        } else {
            $links = Link::byUser($user);
            foreach ($links as $link) {
                $link->setUser();
            }
            return $links;
        }
    }
}