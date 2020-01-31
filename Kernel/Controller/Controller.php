<?php


namespace Kernel;

use Kernel\Response;
use Kernel\Request;

class Controller
{
    /**
     * @var array
     */
    protected static $controllers;

    public function __construct($configurationArray = null)
    {
        $this->configureController($configurationArray);
    }

    public function handle(Response $response, Request $request)
    {
        // Function that will handle request/response in controller entity
    }

    private function configureController($configurationArray)
    {

    }

}