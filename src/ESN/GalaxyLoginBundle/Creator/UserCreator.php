<?php

namespace ESN\GalaxyLoginBundle\Creator;

use ESN\GalaxyLoginBundle\Entity\GalaxyUser;
use ESN\GalaxyLoginBundle\Model\UserModel;

class UserCreator
{
  /**
   * @param $username
   * @param $email
   * @param $galaxyRoles
   * @param $firstName
   * @param $lastName
   * @param $codeSection
   *
   * @return UserModel
   */
  public function createUser($username, $email, $galaxyRoles, $firstName, $lastName, $codeSection)
  {
    $user = new UserModel();
    $user->setUsername($username)
      ->setEmail($email)
      ->setGalaxyRoles(implode(",", $galaxyRoles))
      ->setFirstName($firstName)
      ->setLastName($lastName);

    if (in_array('Local.regularBoardMember', $galaxyRoles)) {
      $user->addRole(GalaxyUser::ROLE_BOARD);
    }
    $user->addRole(GalaxyUser::ROLE_NORMAL)
      ->setCodeSection($codeSection);

    return $user;
  }
}
