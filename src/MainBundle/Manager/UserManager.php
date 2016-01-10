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
        $userDb->setEmail($securityUser->getEmail());
        $userDb->setGalaxyRoles(implode(",", $securityUser->getRoles()));
        $userDb->setFirstname($securityUser->getFirstname());
        $userDb->setLastname($securityUser->getLastname());

        $userDb->setBirthdate(\DateTime::createFromFormat("d/m/Y", $securityUser->getBirthdate()));
        $userDb->setSection($securityUser->getSection());
        $userDb->setCodeSection($securityUser->getSc());

        if (!$userDb) {
            $this->em->persist($userDb);
        }

        $this->em->flush();

        return $userDb;
    }
}
