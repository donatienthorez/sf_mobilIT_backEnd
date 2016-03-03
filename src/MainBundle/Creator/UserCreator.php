<?php

namespace MainBundle\Creator;

use MainBundle\Entity\User;
use MainBundle\Model\UserModel;

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
            $user->addRole(User::ROLE_BOARD);
        }
        $user->addRole(User::ROLE_NORMAL)
            ->setCodeSection($codeSection);

        return $user;
    }
}
