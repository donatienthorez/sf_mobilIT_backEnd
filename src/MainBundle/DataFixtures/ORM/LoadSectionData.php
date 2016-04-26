<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Section;

class LoadSectionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $section1 = (new Section())
            ->setName("Section1")
            ->setCodeSection("TL-SECT-01")
            ->setWebsite("website")
            ->setEmail("email-sect-01@esn.com")
            ->setGalaxyImport(true)
            ->setUniversity("Sect 01 univ")
            ->setLogoUrl("www.urllogo.com")
            ->setPhone("00000000")
            ->setToken("XXXXXXX")
            ->setCountry($this->getReference("countryTL"));

        $section2 = (new Section())
            ->setName("Section2")
            ->setCodeSection("TL-SECT-02")
            ->setCountry($this->getReference("countryTL"));

        $section3 = (new Section())
            ->setName("ESN LILLE")
            ->setCodeSection("FR-LILL-ESL")
            ->setCountry($this->getReference("countryFR"))
            ->setActivated(true);

        $this->addReference("section01", $section1);
        $this->addReference("section02", $section2);
        $this->addReference("sectionLILLE", $section3);

        $manager->persist($section1);
        $manager->persist($section2);
        $manager->persist($section3);
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
