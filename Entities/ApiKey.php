<?php

namespace Entities;

use Doctrine\Mapping as ORM;
use QuantumAPI\Core\iArrayable;
use QuantumAPI\Core\ObjectToArray;

/**
 * ApiKey
 *
 * @Table(name="qe_api_keys", uniqueConstraints={@UniqueConstraint(name="id", columns={"id"})})
 * @Entity
 */
class ApiKey implements iArrayable
{
    use ObjectToArray;

    /**
     * @var string
     *
     * @Column(name="id", type="string", length=255, nullable=false)
     * @Id
     * @GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ApiKey
     */
    public function setId(string $id): ApiKey
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ApiKey
     */
    public function setName(string $name): ApiKey
    {
        $this->name = $name;
        return $this;
    }
}

