<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

class SectionManager
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
     * @param array $sections
     */
    public function saveSections($sections)
    {
        foreach ($sections as $section) {
            if ($this->em->find('MainBundle:Section', $section->getCodeSection())) {
                $this->em->merge($section);
            } else {
                $this->em->persist($section);
            }
        }
        $this->em->flush();
    }
}
