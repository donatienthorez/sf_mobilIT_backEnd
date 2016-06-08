<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;
use MainBundle\Fetcher\SectionFetcher;

class SectionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var SectionFetcher
     */
    private $sectionFetcher;

    /**
     * @param EntityManagerInterface             $em
     * @param \MainBundle\Fetcher\SectionFetcher $sectionFetcher
     */
    public function __construct(
        EntityManagerInterface $em,
        SectionFetcher $sectionFetcher
    ) {
        $this->em = $em;
        $this->sectionFetcher = $sectionFetcher;
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
                ->sectionFetcher
                ->getSection($section->getCodeSection());

            if (!$oldSection) {
                $this->em->persist($section);
                $this->em->flush();
            } else {
                $section->setGuide($oldSection->getGuide());
                $section->setToken($oldSection->getToken());
                $section->setLogoUrl($oldSection->getLogoUrl());
                $section->setAddedAt($oldSection->getAddedAt());
                $section->setUpdatedAt();
                $this->em->merge($section);
                $this->em->flush();
            }
        }
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
