<?php

namespace MainBundle\Creator;

use MainBundle\Model\UserModel;

class UserCreator
{
    public function createUser($username, $email, $gRoles, $firstName, $lastName, $codeSection)
    {
        $user = new UserModel();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setGalaxyRoles(implode(",", $gRoles));
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setCodeSection($codeSection);

        return $user;
    }
}
