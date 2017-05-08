<?php
/**
 * Quantum Restful API Framework
 *
 * @package     Modules\Tools
 * @author      Corin ALEXANDRU <corin.alex@gmail.com>
 * @copyright   2017 - Corin ALEXANDRU
 * @license     MIT
 *
 */

namespace Modules\Tools;

class random
{
    /**
     * Generates a 5 characters token based on the current timestamp
     * @return string
     */
    public static function make_stamp5() : string
    {
        // Current timestamp as string
        $time = strval(time());
        // Replacing numbers
        $var = strtr($time, '0123456789', 'E4HJK6MP2R');
        // Getting the last 5 chars and shuffling
        $stamp5 = str_shuffle(substr($var, -5));
        return $stamp5;
    }

    /**
     * Generates a 14 characters token based on the current timestamp
     * @return string
     */
    public static function make_stamp14() : string
    {
        // Current timestamp as string
        $time = strval(time());
        // 4 more random numbers
        $time .= mt_rand(4096, 8192);
        // Replacing numbers
        $var = strtr($time, '9876543210', 'E2HJK8MP4R');
        // Shuffling
        $stamp14 = str_shuffle($var);
        return $stamp14;
    }

    /**
     * Generates a 12 characters strong password
     * @return string
     */
    public static function make_pwd12() : string
    {
        // Special chars
        $specialChars = array('+', '-', '_', '*', '$', '^', '#', '&');
        // Random 10 chars string
        $password = substr(str_shuffle('AbCdEfGhIjKlMnOpQrStUvWxYz1234567890'),3, 10);
        // Random special char at the start and at the end
        $start = $specialChars[mt_rand(0, sizeof($specialChars) - 1)];
        $end = $specialChars[mt_rand(0, sizeof($specialChars) - 1)];
        // If the start and end chars are the same, we take another
        if ($start == $end) $end = $specialChars[mt_rand(0, sizeof($specialChars) - 1)];
        // The password
        $pwd12 = $start . $password . $end;
        return $pwd12;
    }
}