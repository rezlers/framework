<?php

namespace Kernel\Helpers;

use Kernel\App\App;
use Kernel\Response\ResponseInterface;

function render($template)
{
    global $request;
    $pathToFile = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/');
    $pathToFile .= '/../Templates/' . $template;
    if (is_file($pathToFile)) {
        ob_start();
        include $pathToFile;
        return ob_get_clean();
    }
    return false;
}

function redirect($path): ResponseInterface
{
    return App::Response()->setHeader('Location: ' . $path);
}

function getResource($path)
{
    global $request;
    $pathToFile = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/');
    $pathToFile .= '/../Public/Resources/' . $path;
    if (is_file($pathToFile)) {
        ob_start();
        include $pathToFile;
        return ob_get_clean();
    }
    return false;
}