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

final class Errors {
    public static function errorManager($type, $msg, $file, $row) {
        $err = "Type : " . $type . " | Message : " . $msg . " | File : " . $file . " | Line : " . $row;
        Response::Error(DEBUG ? $err : "An error occured", 500);
    }

    public static function fatalErrorManager() {
        if (@is_array($e = @error_get_last()))
        {
            $type = isset($e['type']) ? $e['type'] : 0;
            $msg = isset($e['message']) ? $e['message'] : '';
            $file = isset($e['file']) ? $e['file'] : '';
            $row = isset($e['line']) ? $e['line'] : '';
            if ($type>0) self::errorManager($type, $msg, $file, $row);
        }
    }

    public static function exceptionManager(\Exception $exception) {
        $err = $exception->getMessage() . " | File : " . $exception->getFile() . " | Line : " . $exception->getLine();
        Response::Error(DEBUG ? $err : "An error occurred", 500);
    }

}

