<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\User
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace Modules\User;

use QuantumAPI\Core\Database;
use QuantumAPI\Core\Module;
use QuantumAPI\Core\Response;
use QuantumAPI\Core\Session;
use Symfony\Component\HttpFoundation\Request;

class main extends Module {
    public function main() {
        Response::Message("User Module");
    }

    /**
     * User login
     */
    public function LoginAction() {
        $r = Request::createFromGlobals();
        $session = Session::getInstance();

        $email = $r->request->get("email");
        $password = $r->request->get("pwd");

        $em = Database::init();
        $user = $em->getRepository("Entities\\Users")->findOneBy(["email" => $email]);

        if (!empty($user)) {
            if (password_verify($password, $user->getPassword())){
                $sid = $session->create($user->getId());
                if ($session->check($sid)) {
                    Response::Message($sid);
                }
            }
        }

        Response::Error("Failed to login");
    }

    /**
     * Checks if an user is logged in
     */
    public function IsValidAction() {
        $r = Request::createFromGlobals();
        $sid = $r->query->get("sid");
        $v = Session::getInstance()->check($sid);

        if ($v) {
            Response::Message($sid);
        }
        else {
            Response::Error("Invalid session");
        }
    }

    /**
     * Log out an user
     */
    public function LogOutAction() {
        $r = Request::createFromGlobals();
        $sid = $r->query->get("sid");
        Session::getInstance()->clear($sid);
        Response::Message("Logged out");
    }
}
