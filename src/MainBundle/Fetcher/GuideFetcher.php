<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;

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

    public function getGuide(Section $section)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->getGuide($section);
    }

    public function count()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Guide')
            ->count();
    }
}
