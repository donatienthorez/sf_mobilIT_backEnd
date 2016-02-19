<?php

namespace MainBundle\Controller\AndroidApi\v1;

use MainBundle\Entity\Section;
use MainBundle\Model\GuideModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FosRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @FosRest\NamePrefix("api_android_guide_v1_")
 */
class GuideController extends Controller
{
    /**
     * @FosRest\Get("/{section}")
     * @ParamConverter("section", class="MainBundle:Section")
     *
     * @FosRest\View()
     *
     * @param Section $section
     *
     * @return GuideModel|array
     */
    public function getAction(Section $section)
    {
        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        $guide = $this
            ->get('main.guide.adapter')
            ->getModel($guide);

        return $guide;
    }
}
