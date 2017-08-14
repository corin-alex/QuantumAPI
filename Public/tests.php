<?php
/**
 * Quantum Restful API Framework
 *
 * @package     QuantumAPI
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

// Autoloader
require_once '../Libraries/autoload.php';

// Config file
require_once '../config.php';

use Symfony\Component\HttpFoundation\Request;

$request =  Request::createFromGlobals();
$route = explode("/", urldecode($request->getQueryString()));

if (empty($route[0]) or empty($route[1])) exit('Bad test request');

$filename = 'test_' . $route[0] . '_' . $route[1] . '.php';
if (file_exists(TESTS_PATH . $filename)) {
    include_once TESTS_PATH . $filename;
}
else {
    echo "Test not found";
}
exit;