<?php
/** For more info about namespaces plase @see http://php.net/manual/en/language.namespaces.importing.php */
namespace Micro\Core;

use Micro\Controller\RouteController;

class Application
{

    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        $this->Router = new RouteController();
    }
}
