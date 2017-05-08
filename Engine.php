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

namespace QuantumAPI;

use QuantumAPI\Core\Module;
use QuantumAPI\Core\Routing;
use QuantumAPI\Core\Response;
use QuantumAPI\Core\Session;

define('API_START', microtime(true));

// Autoloader
require_once 'Libraries/autoload.php';

// Config file
require_once 'config.php';

class Engine {
    public static function start() {
        if (MAINTENANCE) {
            Response::Error("API under maintenance", 503);
        }

        // Error Manager
        error_reporting(0);
        set_error_handler('QuantumAPI\\Core\\Errors::errorManager');
        register_shutdown_function('QuantumAPI\\Core\\Errors::fatalErrorManager');
        set_exception_handler("QuantumAPI\\Core\\Errors::exceptionManager");

        // Authorizing all domains to call the API
        header('Access-Control-Allow-Origin: *');

         // Ckecking API Key
        if (!in_array(Routing::getApiKey(),API_KEY)) {
            Response::Error("Forbidden", 403);
        }

        // Session initialization
        Session::init();

        // Detecting module name from route
        $routeName = Routing::getRouteName();

        if (empty($routeName)) $routeName = DEFAULT_MODULE;
        if (Routing::moduleExists($routeName))
        {
            // Calling the module
            $m_name =  'Modules\\' . $routeName . '\\main';
            if(class_exists($m_name)) {
                $module = new $m_name();
                if ($module instanceof Module) {
                    $module->run();
                    exit;
                }
            }
        }
        Response::Error("Requested module doesn't exists or is invalid", 404);
    }
}