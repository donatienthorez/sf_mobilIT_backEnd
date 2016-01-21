<?php

namespace MainBundle\Service;

use MainBundle\Fetcher\SectionFetcher;

class SectionService
{
    /**
     * @var SectionFetcher
     */
    private $sectionFetcher;

    /**
     * @param SectionFetcher $sectionFetcher
     */
    public function __construct(
        SectionFetcher $sectionFetcher
    ) {
        $this->sectionFetcher = $sectionFetcher;
    }

    public function getSections()
    {
        $data = $this
            ->sectionFetcher
            ->getSections();

        return $data;
    }
}
