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

use Entities\Sessions;
use \Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\HttpFoundation\Request;

class Session {
    private static $_instance = null;

    private function __construct() {}

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Initialize a new session
     */
    public static function init() {
        session_start();
    }

    /**
     * Creates a new user session
     *
     * @param int $userId
     * @return string
     */
    public function create(int $userId) : string {
        session_regenerate_id();
        $sid = sha1(session_id());

        $request = Request::createFromGlobals();
        $em = Database::init();

        $session = $em->getRepository("Entities\\Sessions")->findOneBy(["userId" => $userId]);
        if (empty($session)) $session = new Sessions();
        $session->setId($sid);
        $session->setUserId($userId);
        $session->setIpAddress($request->getClientIp());
        $session->setUserAgent($request->server->get("HTTP_USER_AGENT"));
        $session->setTimestamp(time());

        $em->persist($session);

        $metadata = $em->getClassMetaData(get_class($session));
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $em->flush();

        return $sid;
    }

    /**
     * Checks if a session is valid
     *
     * @param string $sid
     * @return bool
     */
    public function check(string $sid) : bool {
        $request = Request::createFromGlobals();
        $em = Database::init();

        $session = $em->getRepository("Entities\\Sessions")->findOneById($sid);

        if (empty($session) or
            $session->getUserAgent() != $request->server->get("HTTP_USER_AGENT") or
            $session->getIpAddress() != $request->getClientIp()) {
            return false;
        }

        return true;
    }

    /**
     * Destroy a session
     *
     * @param string $sid
     */
    public function clear(string $sid = "") {
        $em = Database::init();
        if (empty($sid)) $sid = session_id();
        $session = $em->getRepository("Entities\\Sessions")->findOneById($sid);
        if (!empty($session)) {
            $em->remove($session);
            $em->flush();
        }

        session_unset();
        session_destroy();
    }

    /**
     * Get the user session id
     *
     * @return string
     */
    public function requestSid() : string {
        $r = Request::createFromGlobals();
        $sidGet = $r->query->get("sid");
        $sidPost = $r->request->get("sid");

        if (empty($sidGet) and empty($sidPost)) {
            return "INVALID";
        }

        if (empty($sidGet) and !empty($sidPost)) {
            return $sidPost;
        }

        elseif (!empty($sidGet) and empty($sidPost)) {
            return $sidGet;
        }
        else {
            return $sidGet;
            //return ($sidGet == $sidPost) ? $sidGet : "INVALID";;
        }

    }
}