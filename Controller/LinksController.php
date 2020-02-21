<?php


namespace App\controller;


use App\Model\Implementations\Link;
use App\Model\Implementations\User;
use App\Model\LinkInterface;
use App\Model\UserInterface;
use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;
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
                if ($request->getParam('action') == 'create') {
                    if ($request->getHttpMethod() == 'GET') {
                        return render('CreateLink.php');
                    } elseif ($request->getHttpMethod() == 'POST') {
                        return $this->createLink($user);
                    }
                } elseif ($request->getParam('action') == 'edit') {
                    if ($request->getHttpMethod() == 'GET') {
                        return render('EditLink.php');
                    } elseif ($request->getHttpMethod() == 'POST') {
                        $link = Link::byId($request->getUrlParams()['id']);
                        return $this->editLink($link);
                    }
                } elseif ($request->getParam('action') == 'description') {
                    if ($request->getHttpMethod() == 'GET') {
                        $_SESSION['linkData'] = Link::byId($request->getUrlParams()['id']);
                        return render('DescriptionLink.php');
                    }
                }
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
        if ($context == 'all') {
            $links = Link::all();
            $linksForUser = [];
            foreach ($links as $link) {
                if ($link->getPrivacyTag() == 'public') {
                    $link->setUser();
                    $linksForUser[] = $link;
                } else {
                    // Different dependencies on user's role
                }
            }
            return $linksForUser;
        } else {
            $links = Link::byUser($user);
            foreach ($links as $link) {
                $link->setUser();
            }
            return $links;
        }
    }

    /**
     * @param UserInterface $user
     * @return bool|false|ResponseInterface|string
     */
    private function createLink(UserInterface $user)
    {
        global $request;
        $params = $request->getParams();
        try {
            $checkLink = Link::byLink($params['link']);
            if (is_null($checkLink)) {
                $link = new Link($params['link'], $params['header'], $params['description'], $params['tag'], $user->getId());
                $link->save();
                return redirect('/links');
            }
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
        $_SESSION['linkData'] = $params;
        $_SESSION['errorMessage'] = 'Link ' . $params['link'] . ' is already exists';
        return redirect('/links/create');
    }

    private function editLink(LinkInterface $link)
    {
        global $request;
        $params = $request->getReqParams();
        try {
            if (isset($params['link']) and $params['link'] != '')
                $link->setLink($params['link']);
            if (isset($params['header']) and $params['header'] != '')
                $link->setHeader($params['header']);
            if (isset($params['description']) and $params['description'] != '')
                $link->setDescription($params['description']);
            if (isset($params['tag']) and $params['tag'] != '')
                $link->setPrivacyTag($params['tag']);
            $link->save();
            return redirect('/links');
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
    }
}