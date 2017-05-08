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

interface iModule{
    /*
     * Initialization login
     * This method is executed first
     */
    function init();

    /*
     * Common startup logic
     * Should call main() at the end
     */
    function run();

    /*
     * Module entry point
     */
    function main();
}