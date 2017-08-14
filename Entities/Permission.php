<?php

namespace Entities;

use Doctrine\Mapping as ORM;

/**
 * Permission
 *
 * @Table(name="qe_permissions")
 * @Entity
 */
class Permission
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @Column(name="type", type="smallint", nullable=false)
     */
    private $type = '0';

    /**
     * @var integer
     *
     * @Column(name="target_id", type="integer", nullable=false)
     */
    private $targetId;

    /**
     * @var string
     *
     * @Column(name="module", type="string", length=255, nullable=false)
     */
    private $module;

    /**
     * @var string
     *
     * @Column(name="action", type="string", length=255, nullable=true)
     */
    private $action;

    /**
     * @var boolean
     *
     * @Column(name="allow", type="boolean", nullable=false)
     */
    private $allow = '0';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Permission
     */
    public function setId(int $id): Permission
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Permission
     */
    public function setType(int $type): Permission
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getTargetId(): int
    {
        return $this->targetId;
    }

    /**
     * @param int $targetId
     * @return Permission
     */
    public function setTargetId(int $targetId): Permission
    {
        $this->targetId = $targetId;
        return $this;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param string $module
     * @return Permission
     */
    public function setModule(string $module): Permission
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Permission
     */
    public function setAction(string $action): Permission
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllow(): bool
    {
        return $this->allow;
    }

    /**
     * @param bool $allow
     * @return Permission
     */
    public function setAllow(bool $allow): Permission
    {
        $this->allow = $allow;
        return $this;
    }
}

