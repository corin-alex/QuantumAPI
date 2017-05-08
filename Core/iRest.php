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

interface iRest
{
    function getAction($request);
    function postAction($request);
    function putAction($request);
    function deleteAction($request);
}