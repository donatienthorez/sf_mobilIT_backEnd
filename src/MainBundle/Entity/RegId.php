<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="regIds")
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\RegIdRepository")
 */
class RegId
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=255)
     * @Expose
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="section", inversedBy="regIds")
     * @ORM\JoinColumn(name="section", referencedColumnName="codeSection")
     * @Expose
     */
    protected $section;

    /**
     * @ORM\Column(name="addedAt", type="datetime")
     */
    protected $addedAt;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->addedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * @param mixed $addedAt
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
}
