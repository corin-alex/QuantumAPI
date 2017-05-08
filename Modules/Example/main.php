<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\Example
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace Modules\Example;

use QuantumAPI\Core\Database;
use QuantumAPI\Core\Module;
use QuantumAPI\Core\Response;

class main extends Module {
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
        Response::Message("Hello World!");
    }
}
