<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries")
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codeCountry", type="string", length=10)
     * @Groups({"list", "details", "section"})
     *
     */
    private $codeCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Groups({"list", "details", "listSection"})
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="text")
     *
     * @Groups({"details"})
     *
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Groups({"details"})
     *
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="section", cascade="all", mappedBy="country")
     *
     * @Groups({"list", "details", "section"})
     */
    protected $sections;

    /**
     * @ORM\Column(name="addedAt", type="datetime")
     *
     * @Groups({"details"})
     */
    protected $addedAt;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     *
     * @Groups({"details"})
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
    public function getCodeCountry()
    {
        return $this->codeCountry;
    }

    /**
     * @param mixed $codeCountry
     */
    public function setCodeCountry($codeCountry)
    {
        $this->codeCountry = $codeCountry;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param mixed $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
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

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
