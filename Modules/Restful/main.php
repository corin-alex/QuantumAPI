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

    public function getAction(){
        Response::Message("Get action");
    }

    public function setAction(){
        Response::Message("Set action");
    }

    public function updateAction(){
        Response::Message("Update action");
    }

    public function deleteAction(){
        Response::Message("Delete action");
    }

    public function patchAction(){
        Response::Message("Patch action");
    }
}
