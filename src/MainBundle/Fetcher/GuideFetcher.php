<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;
use MainBundle\Entity\Country;
use MainBundle\Entity\Guide;

class GuideFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Returns the guide of the section.
     *
     * @param Section $section
     *
     * @return Guide
     */
    public function getGuideBySection(Section $section)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->getGuide($section);
    }

    /**
     * Returns the guide of the country.
     *
     * @param Country $country
     *
     * @return Guide
     */
    public function getGuideByCountry(Country $country)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->getGuideOfCountry($country);
    }

    /**
     * Returns the number of guides.
     *
     * @return int
     */
    public function count()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->count();
    }
}
