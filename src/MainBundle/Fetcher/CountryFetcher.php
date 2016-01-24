<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;

class CountryFetcher
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

    public function getCountries()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Country')
            ->findAll();
    }
}
