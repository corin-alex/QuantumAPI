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

class Response
{
    /**
     * Show an object or an array as json then exists
     *
     * @param $var
     * @param int $code
     * @return void
     */
    public static function Show($var, int $code = 200){
        header('Content-type: application/json; charset=UTF-8 ');
        http_response_code($code);
        echo json_encode($var);
        exit;
    }

    /**
     * Show a json message then exits
     *
     * @param string $msg
     * @return void
     */
    public static function Message($msg) {
        self::Show(["message" => $msg]);
    }

    /**
     * Show a json error then exits
     *
     * @param string $msg
     * @param int $code
     * @return void
     */
    public static function Error(string $msg, int $code = 400) {
        self::Show(["error" => $msg], $code);
    }
}