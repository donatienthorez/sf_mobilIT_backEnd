<?php

namespace ESN\GalaxyLoginBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use ESN\GalaxyLoginBundle\Creator\UserCreator;
use MainBundle\Entity\Section;
use MainBundle\Entity\User as EntityUser;

class UserManager
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  /**
   * @var UserCreator
   */
  private $userCreator;

  /**
   * @param EntityManagerInterface $em
   * @param UserCreator            $userCreator
   */
  public function __construct(
    EntityManagerInterface $em,
    UserCreator $userCreator
  ) {
    $this->em = $em;
    $this->userCreator = $userCreator;
  }

  public function saveUser($username, $attributes)
  {
    $userModel = $this
      ->userCreator
      ->createUser(
        $username,
        $attributes['mail'],
        $attributes['roles'],
        $attributes['first'],
        $attributes['last'],
        $attributes['sc']
      );

    $userDb = $this
      ->em
      ->getRepository("MainBundle:User")
      ->findOneBy(
        array
        (
          "email" => $userModel->getEmail()
        )
      );

    $section = $this
      ->em
      ->getRepository("MainBundle:Section")
      ->findOneBy(
        array
        (
          "codeSection" => $userModel->getCodeSection()
        )
      );

    if (!$section) {
      $section = (new Section())->setCodeSection($userModel->getCodeSection());
      $section->setMandatoryFields();
      $this->em->persist($section);
    }

    $persist = $userDb ? false : true;
    $userDb = (!$userDb) ? new EntityUser() : $userDb;

    $userDb->setUsername($userModel->getUsername())
      ->setEmail($userModel->getEmail())
      ->setGalaxyRoles($userModel->getGalaxyRoles())
      ->setFirstName($userModel->getFirstName())
      ->setLastName($userModel->getLastName())
      ->setRandomPassword()
      ->setSection($section);

    foreach ($userModel->getRoles() as $role) {
      if (!in_array($role, $userDb->getRoles())) {
        $userDb->addRole($role);
      }
    }

    if ($persist) {
      $this->em->persist($userDb);
    }

    $this->em->flush();

    return $userDb;
  }
}
