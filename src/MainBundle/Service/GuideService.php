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

    public function changeStatus(Guide $guide)
    {
        return $this
            ->guideManager
            ->changeStatus($guide);
    }

    public function createGuide($countryGuide = false)
    {
        if ($countryGuide) {

        } else {

        }
    }
}
