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

    public function getCountry($codeCountry)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Country')
            ->findBy(['codeCountry' => $codeCountry]);
    }

    public function getCountries()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Country')
            ->findAll();
    }
}
