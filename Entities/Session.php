<?php

namespace Entities;

use Doctrine\Mapping as ORM;
use QuantumAPI\Core\iArrayable;
use QuantumAPI\Core\ObjectToArray;

/**
 * Session
 *
 * @Table(name="qe_sessions", uniqueConstraints={@UniqueConstraint(name="id", columns={"id"})})
 * @Entity
 */
class Session implements iArrayable
{
    use ObjectToArray;

    /**
     * @var string
     *
     * @Column(name="id", type="string", length=255, nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="ip_address", type="string", length=40, nullable=false)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @Column(name="user_agent", type="string", length=300, nullable=false)
     */
    private $userAgent;

    /**
     * @var integer
     *
     * @Column(name="timestamp", type="integer", nullable=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @Column(name="user_id", type="integer", length=10, nullable=false)
     */
    private $userId = 0;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Session
     */
    public function setId(string $id): Session
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return Session
     */
    public function setIpAddress(string $ipAddress): Session
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return Session
     */
    public function setUserAgent(string $userAgent): Session
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return Session
     */
    public function setTimestamp(int $timestamp): Session
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Session
     */
    public function setUserId(int $userId): Session
    {
        $this->userId = $userId;
        return $this;
    }
}

