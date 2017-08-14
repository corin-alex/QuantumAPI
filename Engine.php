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

use QuantumAPI\Core\Database;
use QuantumAPI\Core\Module;
use QuantumAPI\Core\Routing;
use QuantumAPI\Core\Response;
use QuantumAPI\Core\Session;
use QuantumAPI\Core\StatusCode;

define('API_START', microtime(true));

// Autoloader
require_once 'Libraries/autoload.php';

// Config file
require_once 'config.php';

class Engine {
    public static function start() {
        if (MAINTENANCE) {
            Response::Error("API under maintenance", StatusCode::SERVICE_UNAVAILABLE);
        }

        // Error Manager
        error_reporting(0);
        set_error_handler('QuantumAPI\\Core\\Errors::errorManager');
        register_shutdown_function('QuantumAPI\\Core\\Errors::fatalErrorManager');
        set_exception_handler("QuantumAPI\\Core\\Errors::exceptionManager");

        // Authorizing all domains to call the API
        header('Access-Control-Allow-Origin: *');

        // Ckecking API Key
        if (API_KEY_CHECK) {
            $em = Database::init();
            $key = $em->getRepository("Entities\\ApiKey")->findOneById(Routing::getApiKey());
            if(empty($key))
                Response::Error("Forbidden", StatusCode::FORBIDDEN);
        }

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
        Response::Error("Requested module doesn't exists or is invalid", StatusCode::NOT_FOUND);
    }
}