<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CurrencyEntity
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="currency", schema="currency")
 */
class CurrencyEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="url", type="string")
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(name="order_number", type="integer")
     * @var integer
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\FormatTypeEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var FormatTypeEntity
     */
    private $formatType;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return CurrencyEntity
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return FormatTypeEntity
     */
    public function getFormatType(): FormatTypeEntity
    {
        return $this->formatType;
    }
}