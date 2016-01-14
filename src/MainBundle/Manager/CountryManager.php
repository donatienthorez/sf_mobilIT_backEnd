<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

class CountryManager
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

    /**
     * @param array $countries
     */
    public function saveCountries($countries)
    {
        foreach ($countries as $country) {
            $this->em->persist($country);
        }
        $this->em->flush();
    }
}
