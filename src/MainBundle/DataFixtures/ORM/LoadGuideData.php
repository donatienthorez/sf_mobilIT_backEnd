<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Guide;

class LoadGuideData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $guide1 = (new Guide())
            ->setActivated(true)
            ->setSection($this->getReference("sectionLILLE"));

        $guide2 = (new Guide())
            ->setSection($this->getReference("section01"));

        $this->addReference("guideLILLE", $guide1);
        $this->addReference("guideSection01", $guide2);

        $manager->persist($guide1);
        $manager->persist($guide2);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
