<?php

namespace Kernel\Helpers;

use Kernel\Request;

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