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
            ->findOneBy(['codeCountry' => $codeCountry]);
    }

    public function getCountries($onlyActivated = false)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Country')
            ->findAllActivated($onlyActivated);
    }
}
