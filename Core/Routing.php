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

use Symfony\Component\HttpFoundation\Request;

class Routing
{
    /**
     * Gets the api key from QueryString
     * @return string
     */
    public static function getApiKey() : string
    {
        $request =  Request::createFromGlobals();
        $route = explode("/", urldecode($request->getQueryString()));
        return (!empty($route[0])) ? strtoupper($route[0]) : "";
    }

    /**
     * Gets module name from QueryString
     * @return string
     */
    public static function getRouteName() : string
    {
        $request =  Request::createFromGlobals();
        $route = explode("/", urldecode($request->getQueryString()));
        return (!empty($route[1])) ? ucfirst(strtolower($route[1])) : "";
    }

    /**
     * Gets action name from QueryString
     * @return string
     */
    public static function getActionName() : string
    {
        $request =  Request::createFromGlobals();
        $route = explode("/", urldecode($request->getQueryString()));
        return (!empty($route[2])) ? $route[2] : "";
    }

    /**
     * Checks if a route is valid
     *
     * @param string $route
     * @return bool
     */
    public static function validateRoute(string $route) : bool
    {
        return (!empty($route) and ctype_alnum($route) and self::moduleExists($route));
    }
    /**
     * Checks if a module exists
     *
     * @param string $name
     * @return bool
     */
    public static function moduleExists(string $name) : bool
    {
        if (empty($name)) return false;
        $name = ucfirst(strtolower($name));
        return file_exists(MODULES_PATH . $name . '/' . 'main.php');
    }

    /**
     * Sanitize a variable
     *
     * @param $var
     * @param string $type
     * @return bool|float|null
     * @throws \Exception
     */
    public static function sanitizeVar($var, string $type)
    {
        if (!is_scalar($var)) return null;
        if(!empty($var))
        {
            switch ($type)
            {
                case 'string' :
                    return (string) filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    break;
                case 'alnum' :
                    return (string) preg_replace( '/\W+/', '', $var);
                    break;
                case 'file' :
                    return (string) preg_replace( '/[^a-zA-Z0-9\_\.\-]/', '', $var);
                    break;
                case 'int' :
                    return (int) filter_var($var, FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'float' :
                    return (float) filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
                    break;
                case 'numeric' :
                    return (is_numeric($var)) ? $var : filter_var($var, FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'email' :
                    return (string) filter_var($var, FILTER_SANITIZE_EMAIL);
                    break;
                case 'url' :
                    return (string) Tools::fullUrlEncode(filter_var($var, FILTER_SANITIZE_URL));
                    break;
                case 'bool' :
                    return (bool) (!empty($var) and ($var != false or $var > 0)) ? true : false;
                    break;
                case 'raw' :
                    return $var;
                    break;
                default :
                    throw new \Exception('Invalid variable type "' . $type . '", Routing::sanitizeVar()');
            }
        }
        else
        {
            switch ($type)
            {
                case 'string' :
                case 'email' :
                case 'album' :
                case 'url' :
                    return (string) '';
                    break;
                case 'int' :
                case 'numeric' :
                    return (int) 0;
                    break;
                case 'float' :
                    return (float) 0;
                    break;
                case 'bool' :
                    return (bool) false;
                    break;
                default :
                    return NULL;
            }
        }
    }
}