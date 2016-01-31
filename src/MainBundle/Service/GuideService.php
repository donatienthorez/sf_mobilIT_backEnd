<?php

namespace MainBundle\Service;

use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;
use MainBundle\Fetcher\GuideFetcher;
use MainBundle\Manager\GuideManager;

class GuideService
{
    /**
     * @param GuideFetcher $guideFetcher
     */
    private $guideFetcher;

    /**
     * @param GuideManager $guideManager
     */
    private $guideManager;

    /**
     * @param GuideFetcher $guideFetcher
     * @param GuideManager $guideManager
     */
    public function __construct(
        GuideFetcher $guideFetcher,
        GuideManager $guideManager
    ) {
        $this->guideFetcher = $guideFetcher;
        $this->guideManager = $guideManager;
    }

    public function changeStatus(Section $section)
    {
        $guide = $this
            ->guideFetcher
            ->getGuide($section);

        return $this
            ->guideManager
            ->changeStatus($guide);
    }
}
