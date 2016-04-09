<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;

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

    public function save(Section $section)
    {
        $section->setUpdatedAt();
        $this
            ->em
            ->persist($section);

        $this
            ->em
            ->flush();

        return $section;
    }

    /**
     * @param array $sections
     */
    public function saveSections($sections)
    {
        foreach ($sections as $section) {
            $oldSection = $this
                ->em
                ->find(Section::class, $section->getCodeSection());

            if (!$oldSection) {
                $this->em->persist($section);
            } else {
                $section->setGuide($oldSection->getGuide());
                $section->setToken($oldSection->getToken());
                $section->setLogoUrl($oldSection->getLogoUrl());
                $section->setAddedAt($oldSection->getAddedAt());
                $section->setUpdatedAt();
                $this->em->merge($section);
            }
        }
        $this->em->flush();
    }

    /**
     * @param Section $section
     *
     * @return bool
     */
    public function changeStatus(Section $section)
    {
        $section->isGalaxyImport() ? $section->setGalaxyImport(false) : $section->setGalaxyImport(true);
        $this->em->flush();

        return $section->isGalaxyImport();
    }
}
