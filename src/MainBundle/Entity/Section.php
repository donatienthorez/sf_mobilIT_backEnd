<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="Section")
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codeSection", type="string", length=11)
     *
     * @Groups({"list", "details", "listSection"})
     */
    private $codeSection;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Groups({"list", "details", "listSection"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="text", nullable=true)
     *
     * @Groups({"details"})
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="university", type="text", nullable=true)
     *
     * @Groups({"details"})
     */
    private $university;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     *
     * @Groups({"details"})
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     *
     * @Groups({"details"})
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     *
     * @Groups({"details"})
     */
    private $email;

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

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="sections")
     * @ORM\JoinColumn(name="country", referencedColumnName="codeCountry")
     *
     * @Groups({"list", "details", "listSection"})
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="RegId", cascade="all", mappedBy="section")
     *
     */
    protected $regIds;

    public function __construct()
    {
        $this->addedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCodeSection()
    {
        return $this->codeSection;
    }

    /**
     * @param mixed $codeSection
     */
    public function setCodeSection($codeSection)
    {
        $this->codeSection = $codeSection;
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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @param string $university
     */
    public function setUniversity($university)
    {
        $this->university = $university;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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

    /**
     * @return mixed
     */
    public function getRegIds()
    {
        return $this->regIds;
    }

    /**
     * @param mixed $regIds
     */
    public function setRegIds($regIds)
    {
        $this->regIds = $regIds;
    }
}
