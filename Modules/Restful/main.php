<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\Restful
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace Modules\Restful;

use QuantumAPI\Core\Database;
use QuantumAPI\Core\Module;
use QuantumAPI\Core\Response;
use QuantumAPI\Core\iRest;

class main extends Module implements iRest{
    /**
     * Startup logic
     * @return void
     */
    public function init() {
        // Initialisation du module
    }

    /**
     * Entry point
     * @return void
     */
    public function main() {
        $this->redirectFromMethod();
    }

    public function getAction($request){
        Response::Message("GET action");
    }

    public function postAction($request){
        Response::Message("POST action");
    }

    public function putAction($request){
        Response::Message("PUT action");
    }

    public function deleteAction($request){
        Response::Message("DELETE action");
    }

    public function patchAction($request){
        Response::Message("DELETE action");
    }
}
