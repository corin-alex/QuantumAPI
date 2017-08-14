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
    private $_sessionId = "";

    private function __construct() {}

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Initialize a new session
     * @deprecated Deprecated
     */
    public static function init() {}

    private function generateSessionId($len = 24) {
        $bytes = random_bytes($len);
        $this->_sessionId = bin2hex($bytes);
        return $this->_sessionId;
    }

    /**
     * Creates a new user session
     *
     * @param int $userId
     * @return string
     */
    public function create(int $userId) : string {
        $sid = $this->generateSessionId();

        $request = Request::createFromGlobals();
        $em = Database::init();

        $session = $em->getRepository("Entities\\Session")->findOneBy(["userId" => $userId]);
        if (empty($session)) $session = new \Entities\Session();
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

        $session = $em->getRepository("Entities\\Session")->findOneById($sid);

        if (empty($session) or
            $session->getUserAgent() != $request->server->get("HTTP_USER_AGENT") or
            $session->getIpAddress() != $request->getClientIp()) {
            return false;
        }

        return true;
    }

    public function getUserId(string $sid) : int {
        if(empty($sid)) return 0;

        $em = Database::init();
        $session = $em->getRepository("Entities\\Session")->findOneById($sid);

        return !empty($session) ? $session->getUserId() : 0;
    }

    /**
     * Destroy a session
     *
     * @param string $sid
     */
    public function clear(string $sid = "") {
        $em = Database::init();
        if (empty($sid)) $sid = $this->_sessionId;
        $session = $em->getRepository("Entities\\Session")->findOneById($sid);
        if (!empty($session)) {
            $em->remove($session);
            $em->flush();
        }

        $this->_sessionId = "";
    }

    /**
     * Get the user session id
     *
     * @return string
     */
    public static function getSid() : string {
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
            //return ($sidGet == $sidPost) ? $sidGet : "NOT_VALID";
        }

    }
}