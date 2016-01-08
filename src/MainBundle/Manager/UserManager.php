<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use MainBundle\Security\User as SecurityUser;
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

    public function saveUser(SecurityUser $securityUser)
    {
        $userDb = $this
            ->em
            ->getRepository("MainBundle:User")
            ->findOneBy(
                array
                (
                    "email" => $securityUser->getEmail()
                )
            );

        $userDb = (!$userDb) ? new EntityUser() : $userDb;
        $userDb->setUsername($securityUser->getUsername());
        $userDb->setUsernameCanonical($securityUser->getUsername());
        $userDb->setEmail($userDb->getEmail());
        $userDb->setGalaxyRoles(implode(",", $userDb->getRoles()));
        $userDb->setFirstname($userDb->getFirstname());
        $userDb->setLastname($userDb->getLastname());
        $userDb->setBirthdate($userDb->getBirthdate());
        $userDb->setSection($userDb->getSection());

        if (!$userDb) {
            $this->em->persist($userDb);
        }

        $this->em->flush();

        return $userDb;
    }
}
