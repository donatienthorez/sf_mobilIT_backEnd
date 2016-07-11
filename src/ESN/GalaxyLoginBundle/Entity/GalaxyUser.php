<?php

namespace ESN\GalaxyLoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;

/** @ORM\MappedSuperclass */
abstract class GalaxyUser extends BaseUser implements UserInterface
{
  const ROLE_NORMAL = 'ROLE_NORMAL';
  const ROLE_BOARD  = 'ROLE_BOARD';
  const ROLE_ADMIN  = 'ROLE_ADMIN';

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")r
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="firstname", type="string", length=255)
   */
  private $firstName;

  /**
   * @var string
   *
   * @ORM\Column(name="lastname", type="string", length=255)
   */
  private $lastName;

  /**
   * @var string
   *
   * @ORM\Column(name="galaxy_roles", type="text", nullable=true)
   */
  private $galaxy_roles;

  /**
   * @ORM\ManyToOne(targetEntity="Section", inversedBy="users")
   * @ORM\JoinColumn(name="section", referencedColumnName="codeSection", nullable=false)
   *
   */
  protected $section;

  /**
   * @return string
   */
  public function getFullName()
  {
    return $this->getFirstName() . " " . $this->getLastName();
  }
  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getGalaxyRoles()
  {
    return $this->galaxy_roles;
  }

  /**
   * @param mixed $galaxy_roles
   *
   * @return $this
   */
  public function setGalaxyRoles($galaxy_roles)
  {
    $this->galaxy_roles = $galaxy_roles;

    return $this;
  }

  /**
   * @return string
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   * @param string $firstName
   *
   * @return $this
   */
  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;

    return $this;
  }

  /**
   * @return string
   */
  public function getLastName()
  {
    return $this->lastName;
  }

  /**
   * @param string $lastName
   *
   * @return $this
   */
  public function setLastName($lastName)
  {
    $this->lastName = $lastName;

    return $this;
  }

  /**
   * @return string
   */
  public function getSection()
  {
    return $this->section;
  }

  /**
   * @param string $section
   *
   * @return $this
   */
  public function setSection($section)
  {
    $this->section = $section;

    return $this;
  }

  public function setRandomPassword()
  {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    $this->setPlainPassword(implode($pass)); //turn the array into a string

    return $this;
  }
}
