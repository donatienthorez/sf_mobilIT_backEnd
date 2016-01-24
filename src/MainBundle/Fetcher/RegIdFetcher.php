<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;

class RegIdFetcher
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

    public function getRegIdsFromSection($section)
    {
        return $this
            ->em
            ->getRepository('MainBundle:RegId')
            ->findBy(
                array('section' => $section)
            );
    }

    public function count()
    {
        return $this
            ->em
            ->getRepository('MainBundle:RegId')
            ->count();
    }
}
