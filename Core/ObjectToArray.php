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

trait ObjectToArray
{
    /**
     * Converts an object to array
     * Children which cannot convert to array are replaced by empty arrays
     *
     * @return array
     */
    public function toArray(): array
    {
        $props = array();
        foreach ((array)$this as $key => $value) {
            if (substr($key, 0, 2) == '__') continue;

            if (is_object($value)) {
                $value = method_exists($value, 'toArray') ? $value->toArray() :  array();
            }

            $props[basename(str_ireplace("\0", "\\", $key))] = $value;
        }
        return $props;
    }
}