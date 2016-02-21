<?php

namespace MainBundle\Service;

use MainBundle\Entity\Section;
use MainBundle\Fetcher\SectionFetcher;
use MainBundle\Manager\SectionManager;

class SectionService
{
    /**
     * @var SectionFetcher
     */
    private $sectionFetcher;
    /**
     * @var SectionManager
     */
    private $sectionManager;

    /**
     * @param SectionFetcher $sectionFetcher
     * @param SectionManager $sectionManager
     */
    public function __construct(
        SectionFetcher $sectionFetcher,
        SectionManager $sectionManager
    ) {
        $this->sectionFetcher = $sectionFetcher;
        $this->sectionManager = $sectionManager;
    }

    public function getSections()
    {
        $data = $this
            ->sectionFetcher
            ->getSections();

        return $data;
    }

    public function generateToken(Section $section)
    {
        $section->generateToken();
        $this
            ->sectionManager
            ->save($section);

        return $section->getToken();
    }
}
