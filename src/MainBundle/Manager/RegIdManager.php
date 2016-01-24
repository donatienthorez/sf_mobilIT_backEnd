<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Creator\RegIdCreator;
use MainBundle\Entity\RegId;

class RegIdManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var RegIdCreator
     */
    private $regIdCreator;

    /**
     * @param EntityManagerInterface $em
     * @param RegIdCreator $regIdCreator
     */
    public function __construct(
        EntityManagerInterface $em,
        RegIdCreator $regIdCreator
    ) {
        $this->em = $em;
        $this->regIdCreator = $regIdCreator;
    }

    public function saveRegId($regId, $section)
    {
        $regIdDb = $this->em->find('MainBundle:RegId', $regId);
        $section = $this->em->find('MainBundle:Section', $section);

        if ($regIdDb) {
            $regIdDb->setSection($section);
        } else {
            $this->em->persist($this->regIdCreator->createRegId($regId, $section));
        }

        $this
            ->em
            ->flush();

    }
}
