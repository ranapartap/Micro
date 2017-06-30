<?php
/**
 * There are some variables attached to every function which is called from RouterController,
 * these variables are set by our Router, You can read more on https://github.com/klein/klein.php
 * We have pass these variables to our controller functions to act on Request, Response, Services and App
 *
 * @param type $req - Request Object - Like URI, Request Parameters etc.
 * @param type $res - Respond to all requests like get, put, handle uri requests etc.
 * @param type $service - Handle Views etc.
 * @param type $app - Custom declared global variables
 */
namespace Micro\Controller;

use Micro\Controller\BaseController;
use Micro\Core\SessionManager;
use Micro\Core\Application;

class AuthController extends BaseController {

    public function login() {

        Application::$service->render(getPath('view') . 'auth/login.php');
    }

    public function do_login() {

        if(Application::$service->username)

        $session = new SessionManager;
        $session->setSessionKey('user', ['role' => 1, 'user_name'=> 'Administrator']);

        return Application::$response->redirect(admin_url('', false));
    }

    public function logout() {
        $session = new SessionManager;
        $session->clearSession();

        return Application::$response->redirect(getBaseUrl());
    }

}
