<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use MainBundle\Entity\Section;
use MainBundle\Model\GuideModel;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @FosRest\NamePrefix("api_android_guide_v1_")
 */
class GuideController extends Controller
{
    /**
     * @FosRest\Get("/{section}")
     *
     * @ApiDoc(
     *  description = "Get the guide of a section"
     * )
     *
     * @ParamConverter("section", class="MainBundle:Section")
     *
     * @FosRest\QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token."
     * )
     * @param Section $section
     * @param ParamFetcher $paramFetcher
     *
     * @return array|GuideModel
     */
    public function getAction(Section $section, ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response(
                json_encode(["message" => $this->get('translator')->trans("errors.api.android.v1.token")]),
                Response::HTTP_FORBIDDEN
            );
        }

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        $guide = $this
            ->get('main.guide.adapter')
            ->getModel($guide, true);

        return $guide;
    }
}
