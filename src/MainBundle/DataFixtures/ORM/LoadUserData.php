<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = (new User())
            ->setUsername('user1')
            ->setPassword('user1')
            ->setSection(
                $this->getReference("section01")
            )
            ->setEmail("user1@mail.com")
            ->setFirstName("FirstName User1")
            ->setLastName("LastName User1");

        $manager->persist($userAdmin);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}

