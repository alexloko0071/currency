<?php

namespace App\Entity;


use App\Service\JsonParserService;
use App\Service\Parser;
use App\Service\XmlParserService;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FormatTypeEntity
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="type", schema="currency")
 */
class FormatTypeEntity
{
    public const JSON_ALIAS = 'json';
    public const XML_ALIAS = 'xml';

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     * @var string
     */
    private $name;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Parser
     * @throws EntityNotFoundException
     */
    public function getParserService(): Parser
    {
        switch ($this->getName()) {
            case FormatTypeEntity::JSON_ALIAS:
                return new JsonParserService();
                break;
            case FormatTypeEntity::XML_ALIAS:
                return new XmlParserService();
                break;
            default:
                throw new EntityNotFoundException('type alias is wrong');
        }
    }
}