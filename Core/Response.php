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
    public static function Show($var, int $code = StatusCode::OK){
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
    public static function Error(string $msg, int $code = StatusCode::BAD_REQUEST) {
        self::Show(["error" => $msg], $code);
    }

    /**
     * Render an image from a file
     *
     * @param string $path
     * @return void
     */
    public static function Image(string $path) {
        if (file_exists(UPLOAD_PATH . $path)) {
            $validTypes = ["image/png", "image/jpeg", "image/gif"];
            $mime = mime_content_type(UPLOAD_PATH . $path);

            if (!in_array($mime, $validTypes)) {
                self::Error("Image not valid or corrupted", StatusCode::UNSUPPORTED_MEDIA_TYPE);
            }

            header("Content-type: $mime; charset=UTF-8");

            http_response_code(StatusCode::OK);
            echo file_get_contents(UPLOAD_PATH . $path);
            exit;
        }
        else {
            self::Error("Image not found", StatusCode::NOT_FOUND);
        }
    }
}