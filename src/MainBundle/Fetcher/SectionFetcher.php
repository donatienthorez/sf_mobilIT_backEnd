<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;

class SectionFetcher
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

    public function getSections()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Section')
            ->findAll();
    }

    public function getSection($codeSection)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Section')
            ->find($codeSection);
    }
}
