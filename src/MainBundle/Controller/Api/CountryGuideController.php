<?php

namespace MainBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use JMS\Serializer\SerializationContext;
use MainBundle\Controller\Api\Base\BaseController;

/**
 * @FosRest\NamePrefix("api_country_guides_")
 */
class CountryGuideController extends BaseController
{
    /**
     * @FosRest\View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction()
    {
        $section = $this->getUser()->getSection();
        $country = $section->getCountry();

        $this->checkPermissionsForCountry($country);

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuideByCountry($country);

        return $this
            ->get('main.guide.adapter')
            ->getModel($guide);
    }


    /**
     * @FosRest\Put()
     * @FosRest\View()
     *
     * @Security("has_role('ROLE_BOARD_NATIONAL')")
     */
    public function changeStatusAction()
    {
        $section = $this->getUser()->getSection();
        $country = $section->getCountry();

        $this->checkPermissionsForCountry($country);

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuideByCountry($country);

        return $this
            ->get('main.guide.service')
            ->changeStatus($guide);
    }
}
