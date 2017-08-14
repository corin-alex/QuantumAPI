<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\Index
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin Alexandru
 * @license     All Rights Reserved
 *
 */

namespace Modules\Index;

use QuantumAPI\Core\Module;
use QuantumAPI\Core\Response;

class main extends Module {
    public function main() {
        Response::Message("QuantumAPI");
    }
}
