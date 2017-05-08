<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\Tools
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace Modules\Tools;

use QuantumAPI\Core\Module;
use QuantumAPI\Core\Response;
use Symfony\Component\HttpFoundation\Request;

class main extends Module {

    public function main() {
        Response::Message("Available actions : GenerateGuid | GenerateToken | GenerateLongToken | GeneratePassword | GetTimestamp");
    }

    /**
     * Generates a GUID on windows platform
     */
    protected function GenerateGuidAction() {
        if (function_exists("com_create_guid")) {
            Response::Message(com_create_guid());
        }

        Response::Error("Windows Only");
    }

    protected function GenerateTokenAction() {
        Response::Message(random::make_stamp5());
    }

    protected function GenerateLongTokenAction() {
        Response::Message(random::make_stamp14());
    }

    protected function GeneratePasswordAction() {
        Response::Message(random::make_pwd12());
    }

    /**
     * Show the current timestamp
     */
    protected function GetTimestampAction() {
        Response::Message(time());
    }

    /**
     * Encrypt a password
     * @method POST
     */
    protected function EncryptPasswordAction() {
        $r = Request::createFromGlobals();
        $password = $r->request->get("pwd");
        Response::Message(password_hash($password, PASSWORD_DEFAULT));
    }
}
