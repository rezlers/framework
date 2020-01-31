<?php


namespace Kernel;


class Response
{
    public function __invoke()
    {
        echo 'response body';
    }
}