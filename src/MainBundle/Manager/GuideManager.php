<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Guide;

class GuideManager
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

    public function changeStatus(Guide $guide)
    {
        $guide
            ->setActivated
            (!$guide->getActivated());
        $this->em->persist($guide);
        $this->em->flush();

        return $guide->getActivated();
    }
}
