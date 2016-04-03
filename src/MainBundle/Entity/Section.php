<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity
 * @ORM\Table(name="sections")
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
     * @Groups({"details", "listSection"})
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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Groups({"details"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true, unique=true)
     *
     * @Groups({"token"})
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="logoUrl", type="text", nullable=true)
     * @Groups({"details"})
     */
    private $logoUrl;

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

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="sections")
     * @ORM\JoinColumn(name="country", referencedColumnName="codeCountry")
     * @Groups({"list", "listSection"})
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="RegId", cascade="all", mappedBy="section")
     */
    protected $regIds;

    /**
     * @ORM\OneToMany(targetEntity="Notification", cascade="all", mappedBy="section")
     */
    protected $notification;

    /**
     * @ORM\OneToMany(targetEntity="User", cascade="all", mappedBy="section")
     */
    protected $users;

    /**
     * @ORM\OneToOne(targetEntity="Guide")
     * @ORM\JoinColumn(name="guide", referencedColumnName="id")
     */
    protected $guide;

    /**
     * @ORM\Column(type="boolean", name="activated", options={"default": false})
     * @Groups({"activated"})
     */
    protected $activated;

    /**
     * @ORM\Column(type="boolean", name="galaxy_import", options={"default": false})
     * @Groups({"galaxyImport"})
     */
    protected $galaxyImport;

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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
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
     *
     * @return $this
     */
    public function setUniversity($university)
    {
        $this->university = $university;

        return $this;
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
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
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
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

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

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     *
     * @return $this
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;

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
     * @return $this
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
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

    /**
     * @return boolean
     */
    public function isActivated()
    {
        return $this->activated;
    }

    /**
     * @param boolean $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    /**
     * @return boolean
     */
    public function isGalaxyImport()
    {
        return $this->galaxyImport;
    }

    /**
     * @param boolean $galaxyImport
     */
    public function setGalaxyImport($galaxyImport)
    {
        $this->galaxyImport = $galaxyImport;
    }

    public function __toString()
    {
        return (string) $this->getCodeSection();
    }

    public function generateToken()
    {
        $this->token = bin2hex(random_bytes(20));
    }
}
