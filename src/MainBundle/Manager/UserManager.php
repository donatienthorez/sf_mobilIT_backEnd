<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use MainBundle\Entity\User;
use MainBundle\Model\UserModel;
use MainBundle\Entity\User as EntityUser;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function saveUser(UserModel $userModel)
    {
        $userDb = $this
            ->em
            ->getRepository("MainBundle:User")
            ->findOneBy(
                array
                (
                    "email" => $userModel->getEmail()
                )
            );


        $sectionDb = $this
            ->em
            ->getRepository("MainBundle:Section")
            ->findOneBy(
                array
                (
                    "codeSection" => $userModel->getCodeSection()
                )
            );


        $persist = $userDb ? false : true;
        $userDb = (!$userDb) ? new EntityUser() : $userDb;

        $userDb->setUsername($userModel->getUsername());
        $userDb->setEmail($userModel->getEmail());
        $userDb->setGalaxyRoles($userModel->getGalaxyRoles());
        $userDb->setFirstName($userModel->getFirstName());
        $userDb->setLastName($userModel->getLastName());
        $userDb->setRandomPassword();
        $userDb->setSection($sectionDb);
        if ($persist) {
            $userDb->addRole(User::ROLE_NORMAL);
            $this->em->persist($userDb);
        }

        $this->em->flush();

        return $userDb;
    }
}
