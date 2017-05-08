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

// Exiting if the file is included
if(sizeof(get_included_files()) > 1) exit;

require_once '../Engine.php';

use Doctrine\ORM\Tools\SchemaTool;
use QuantumAPI\Core\Database;

echo "<!DOCTYPE html><head><title>QuantumAPI - Installation</title></head><body><pre>";

$db = Database::init();
$st = new SchemaTool($db);
echo "- Droping database" .  PHP_EOL;
$st->dropDatabase();

echo "- Creating tables" .  PHP_EOL;
$classes = array(
    $db->getClassMetadata('Entities\Users'),
    $db->getClassMetadata('Entities\Sessions'),
    $db->getClassMetadata('Entities\Permissions'),
);
$st->createSchema($classes);

echo "- Populating tables" .  PHP_EOL;


echo  PHP_EOL . "Done" .  PHP_EOL;
echo "</pre></body></html>";