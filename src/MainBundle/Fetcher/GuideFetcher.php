<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;

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

    public function getGuide($section)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->getGuide($section);
    }
}
