<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\RegId;

class LoadRegIdData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $regId1 = (new RegId())
            ->setId("testRegid02")
            ->setSection($this->getReference("section01"));

        $regId2 = (new RegId())
            ->setId("testRegid03")
            ->setSection($this->getReference("section01"));

        $manager->persist($regId1);
        $manager->persist($regId2);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}
