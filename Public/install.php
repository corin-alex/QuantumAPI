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
    $db->getClassMetadata('Entities\ApiKey'),
    $db->getClassMetadata('Entities\User'),
    $db->getClassMetadata('Entities\Session'),
    $db->getClassMetadata('Entities\Permission')
);
$st->createSchema($classes);

echo "- Generating API Keys" .  PHP_EOL;
$androidKey = new Entities\ApiKey();
$androidKey->setName('Android');
$db->persist($androidKey);

$iosKey = new Entities\ApiKey();
$iosKey->setName('iOS');
$db->persist($iosKey);

$uwpKey = new Entities\ApiKey();
$uwpKey->setName('UWP');
$db->persist($uwpKey);

$browserKey = new Entities\ApiKey();
$browserKey->setName('Web');
$db->persist($browserKey);

echo "- Creating user quantum@engine.test (Password : 123456)" .  PHP_EOL;
$testUser = new Entities\User();
$testUser->setEmail("quantum@engine.test");
$testUser->setPassword('$2y$10$agaE6e.4bAvklwv8YOQcjupGfeSzIbGCihrYpGIVrtiAKiejefubG');
$db->persist($testUser);

echo "- Setting user permissions" .  PHP_EOL;
$userPermissions = new Entities\Permission();
$userPermissions->setType(0)->setModule('Preferences')->setAction('Get')->setTargetId(0)->setAllow(true);
$db->persist($userPermissions);

$userPermissions = new Entities\Permission();
$userPermissions->setType(0)->setModule('Preferences')->setAction('Set')->setTargetId(0)->setAllow(true);
$db->persist($userPermissions);

$userPermissions = new Entities\Permission();
$userPermissions->setType(0)->setModule('Ebillet')->setAction('Get')->setTargetId(0)->setAllow(true);
$db->persist($userPermissions);

$userPermissions = new Entities\Permission();
$userPermissions->setType(0)->setModule('Ebillet')->setAction('List')->setTargetId(0)->setAllow(true);
$db->persist($userPermissions);

$userPermissions = new Entities\Permission();
$userPermissions->setType(0)->setModule('Ebillet')->setAction('Generate')->setTargetId(0)->setAllow(true);
$db->persist($userPermissions);


$db->flush();

echo  PHP_EOL . "Done" .  PHP_EOL;
echo "</pre></body></html>";