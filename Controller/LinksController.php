<?php


namespace App\controller;


use App\Model\Implementations\Link;
use App\Model\Implementations\User;
use App\Model\LinkInterface;
use App\Model\UserInterface;
use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\PagerInterface;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;
use function Kernel\Helpers\render;

class LinksController implements ControllerInterface
{

//    /**
//     * @param Request $request
//     * @return mixed
//     */
//    public function handle(Request $request)
//    {
//        session_start();
//        try {
//            if (isset($_SESSION['userId'])) {
//                $user = User::getById($_SESSION['userId']);
//                if ($request->getParam('action') == 'create') {
//                    if ($request->getHttpMethod() == 'GET') {
//                        return render('CreateLink.php');
//                    } elseif ($request->getHttpMethod() == 'POST') {
//                        return $this->createLink($user);
//                    }
//                } elseif ($request->getParam('action') == 'edit') {
//                    if ($request->getHttpMethod() == 'GET') {
//                        $_SESSION['linkData'] = Link::byId($request->getUrlParams()['id']);
//                        return render('EditLink.php');
//                    } elseif ($request->getHttpMethod() == 'POST') {
//                        $link = Link::byId($request->getUrlParams()['id']);
//                        return $this->editLink($link);
//                    }
//                } elseif ($request->getParam('action') == 'description') {
//                    if ($request->getHttpMethod() == 'GET') {
//                        $link = Link::byId($request->getUrlParams()['id']);
//                        if (is_null(parse_url($link->getLink(), PHP_URL_SCHEME)))
//                            $link->setLink('http://' . $link->getLink());
//                        $_SESSION['linkData'] = $link;
//                        return render('DescriptionLink.php');
//                    }
//                }
//                if ($request->getPath() == '/main') {
//                    if (!is_null($request->getParam('page')))
//                        $_SESSION['linkData'] = $this->getLinks('all', $request->getParam('page'), $user);
//                    else
//                        $_SESSION['linkData'] = $this->getLinks('all', 1, $user);
//                    $_SESSION['pagerData'] = $this->getPages(Link::byTag('public'));
//                    return render('MainPage.php');
//                } elseif ($request->getPath() == '/links') {
//                    if (!is_null($request->getParam('page')))
//                        $_SESSION['linkData'] = $this->getLinks('personal', $request->getParam('page'), $user);
//                    else
//                        $_SESSION['linkData'] = $this->getLinks('personal', 1, $user);
//                    $_SESSION['pagerData'] = $this->getPages(Link::byUser($user));
//                    return render('UserLinks.php');
//                }
//            } elseif ($request->getPath() == '/main') {
//                if (!is_null($request->getParam('page')))
//                    $_SESSION['linkData'] = $this->getLinks('all', $request->getParam('page'));
//                else
//                    $_SESSION['linkData'] = $this->getLinks('all', 1);
//                $_SESSION['pagerData'] = $this->getPages(Link::byTag('public'));
//                return render('MainPage.php');
//            }
//        } catch (ModelException $exception) {
//            $container = new ServiceContainer();
//            $container->getService('Logger')->error($exception->getMessage());
//            return abort(500);
//        }
//        return App::Response()->setStatusCode(404);
//    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     */
    public function getCreateLinkPage(RequestInterface $request)
    {
        return render('CreateLink.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getEditLinkPage(RequestInterface $request)
    {
        $link = Link::byId($request->getUrlParams()['id']);
        $request->addParam('linkData', [
            'link' => $link->getLink(),
            'header' => $link->getHeader(),
            'tag' => $link->getPrivacyTag(),
            'description' => $link->getDescription()
        ]);
        return render('EditLink.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getLinkDescriptionPage(RequestInterface $request)
    {
        $link = Link::byId($request->getUrlParams()['id']);
        $request->addParam('linkData', $link);
        return render('DescriptionLink.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getUserLinksPage(RequestInterface $request)
    {
        $user = User::getById($_SESSION['userId']);
        if (!is_null($request->getParam('page')))
            $request->addParam('linkData', $this->getLinks('personal', $request->getParam('page'), $user));
        else
            $request->addParam('linkData', $this->getLinks('personal', 1, $user));
        $request->addParam('pagerData', $this->getPages(Link::byUser($user)));
        return render('UserLinks.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getMainPage(RequestInterface $request)
    {
        if (isset($_SESSION['userId'])) {
            $user = User::getById($_SESSION['userId']);
            if (!is_null($request->getParam('page')))
                $request->addParam('linkData', $this->getLinks('all', $request->getParam('page'), $user));
            else
                $request->addParam('linkData', $this->getLinks('all', 1, $user));
            $request->addParam('pagerData', $this->getPages(Link::byTag('public')));
        } else {
            if (!is_null($request->getParam('page')))
                $request->addParam('linkData', $this->getLinks('all', $request->getParam('page')));
            else
                $request->addParam('linkData', $this->getLinks('all', 1));
            $request->addParam('pagerData', $this->getPages(Link::byTag('public')));
        }
        return render('MainPage.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|ResponseInterface|string
     * @throws ModelException
     */
    public function createLink(RequestInterface $request)
    {
        $user = User::getById($_SESSION['userId']);
        $params = $request->getParams();
        try {
            $url = $params['link'];
            if (is_null(parse_url($params['link'], PHP_URL_SCHEME))) {
                $url = 'http://' . $url;
            }
            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                $request->addParam('linkData', $params);
                $request->addParam('errorMessage', 'Link ' . $params['link'] . ' is not valid');
                return render('CreateLink.php');
            }
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
        $request->addParam('linkData', $params);
        $request->addParam('errorMessage', 'Link ' . $params['link'] . ' is already exists');
        return render('CreateLink.php');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ModelException
     */
    public function editLink(RequestInterface $request)
    {
        $link = Link::byId($request->getUrlParams()['id']);
        $params = $request->getReqParams();
        try {
            if (filter_var($params['link'], FILTER_VALIDATE_URL) === false) {
                $request->addParam('linkData', $params);
                $request->addParam('errorMessage', 'Link ' . $params['link'] . ' is not valid');
                return render('CreateLink.php');
            }
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

    /**
     * @param UserInterface $user
     * @param string $context
     * @param int $currentPage
     * @return Link[]|array
     * @throws ModelException
     */
    private function getLinks(string $context, int $currentPage, UserInterface $user = null)
    {
        if ($context == 'all') {
            $links = Link::byPage($currentPage);
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
            $links = Link::byPage($currentPage, $user->getId());
            foreach ($links as $link) {
                $link->setUser();
            }
            return $links;
        }
    }

    /**
     * @param array $links
     * @return array
     */
    private function getPages(array $links): array
    {
        /** @var RequestInterface $request */
        global $request;
        $container = new ServiceContainer();
        /** @var PagerInterface $pager */
        $pager = $container->getService('Pager');
        if (!is_null($request->getParam('page'))) {
            return $pager->getPages($request->getParam('page'), count($links), trim($request->getPath(), '/'));
        }
        return $pager->getPages(1, count($links), trim($request->getPath(), '/'));
    }
}
