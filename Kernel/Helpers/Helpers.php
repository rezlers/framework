<?php

namespace Kernel\Helpers;

use Kernel\App\App;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;

function render($template, Request $request)
{
    $pathToFile = $_SERVER['DOCUMENT_ROOT'];
    $pathToFile .= '/../Templates/' . $template;
    if (is_file($pathToFile)) {
        ob_start();
        include $pathToFile;
        return ob_get_clean();
    }
    return false;
}

function redirect($path) : ResponseInterface
{
    return App::Response()->setHeader('Location: ' . $path);
}