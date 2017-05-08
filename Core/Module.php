<?php
/**
 * Quantum Restful API Framework
 *
 * @package     QuantumAPI\Core
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace QuantumAPI\Core;

use Symfony\Component\HttpFoundation\Request;

abstract class Module implements iModule {
    public function init() {}

    /**
     * Startup logic
     */
    public function run() {
        $this->init();
        $this->callbackFromRoute();
        $this->main();
    }

    /**
     * Call the action corresponding to the request method
     *
     * @param void
     * @return void
     * @throws \Exception
     */
    protected function redirectFromMethod() {
        $request =  Request::createFromGlobals();
        switch ($request->server->get('REQUEST_METHOD')) {
            case 'GET':
                $this->getAction(null);
                break;
            case 'POST':
                $this->postAction();
                break;
            case 'PUT':
                $this->putAction();
                break;
            case 'DELETE':
                $this->deleteAction();
                break;
            default:
                throw new \Exception ('Invalid request method');
                break;
        }
    }

    /**
     * Call the requested action if exists
     *
     * @return void
     */
    protected function callbackFromRoute() {
        $methodName = Routing::getActionName() . "Action";

        // If no action
        if ($methodName == "Action") return;

        // If the requested action doesn't exists
        if (!is_callable([$this, $methodName])){
            Response::Error("Invalid action", 404);
        }
        $this->$methodName();
        exit;
    }

    /**
     * Show an error if the user is not logged in
     */
    protected function requestRegisteredUser() {
        $r = Request::createFromGlobals();
        $sid = $r->query->get("sid");

        if (!Session::getInstance()->check($sid)) {
            Response::Error("User not logged in", 401);
        }
    }

    /**
     * Checks if an user has the permission to call an action
     *
     */
    protected function isAuth() {
        $session =  Session::getInstance();
        $sid = $session->requestSid();
        $uid = 0;
        $utype = 0;
        $em = Database::init();
        if ($session->check($sid)) {

            $user = $em->getRepository("Entities\\Sessions")->findOneById($sid);
            $uid =  $user->getUserId();
            $utype = $user->getUserType();
        }

        $allowed = false;

        $actionName =  Routing::getActionName();
        if (empty($actionName)) $actionName = "main";

        $auth = $em->getRepository("Entities\\Permissions")->findOneBy(["type" => 1,
                                                                                   "targetId" => $uid,
                                                                                   "module" => Routing::getRouteName(),
                                                                                   "action" => $actionName]);
        if (!empty($auth)) {
            $allowed = $auth->isAllow();
        }
        else {
            $auth = $em->getRepository("Entities\\Permissions")->findOneBy(["type" => 0,
                                                                                       "targetId" => $utype,
                                                                                       "module" => Routing::getRouteName(),
                                                                                       "action" => $actionName]);
            if (!empty($auth)) {
                $allowed = $auth->isAllow();
            }
        }

        if (!$allowed) {
            Response::Error("Forbidden", 403);
        }

    }
}
