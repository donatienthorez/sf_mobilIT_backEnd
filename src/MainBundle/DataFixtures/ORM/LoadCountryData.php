<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Country;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $country1 = (new Country())
            ->setName("France")
            ->setCodeCountry("FR")
            ->setWebsite("http://esnlille.fr")
            ->setEmail("contact@esnlille.fr");

        $country2 = (new Country())
            ->setName("TEST LAND")
            ->setCodeCountry("TL")
            ->setWebsite("http://testland.com")
            ->setEmail("contact@testland.com");

        $this->addReference("countryFR", $country1);
        $this->addReference("countryTL", $country2);

        $manager->persist($country1);
        $manager->persist($country2);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
