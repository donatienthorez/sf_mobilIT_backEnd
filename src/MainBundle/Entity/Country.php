<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codeCountry", type="string", length=10)
     * @Groups({"list", "details", "section"})
     *
     */
    protected $codeCountry;

    /**
     * @ORM\OneToOne(targetEntity="Guide")
     * @ORM\JoinColumn(name="guide", referencedColumnName="id")
     */
    protected $guide;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"list", "details", "listSection"})
     */
    protected $name;

    /**
     * @ORM\Column(name="website", type="text")
     * @Groups({"details"})
     */
    protected $website;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @Groups({"details"})
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Section", cascade="all", mappedBy="country")
     * @Groups({"details", "section", "listSection"})
     */
    protected $sections;

    /**
     * @ORM\Column(name="addedAt", type="datetime")
     * @Groups({"details"})
     */
    protected $addedAt;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     * @Groups({"details"})
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->addedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getCodeCountry()
    {
        return $this->codeCountry;
    }

    /**
     * @param string $codeCountry
     *
     * @return $this
     */
    public function setCodeCountry($codeCountry)
    {
        $this->codeCountry = $codeCountry;

        return $this;
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
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     *
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
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
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getSection($codeSection) {
        foreach ($this->sections as $section) {
            if ($section->getCodeSection() === $codeSection) {
                return $section;
            }
        }
        return null;
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
     *
     * @return $this
     */
    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
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
     *
     * @return $this
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;

        return $this;
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
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
