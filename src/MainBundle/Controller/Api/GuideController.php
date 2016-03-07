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
use MainBundle\Entity\Category;
use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;
use MainBundle\Model\CategoryModel;
use MainBundle\Model\GuideModel;
use MainBundle\Security\Voter\SectionVoter;

/**
 * @FosRest\NamePrefix("api_guides_")
 */
class GuideController extends BaseController
{
    /**
     * @FosRest\View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction()
    {
        $section = $this->getUser()->getSection();

        $this->checkPermissionsForSection($section);

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        return $this
            ->get('main.guide.adapter')
            ->getModel($guide);
    }

    /**
     * @FosRest\Put()
     * @FosRest\View()
     *
     * @Security("has_role('ROLE_BOARD')")
     */
    public function changeStatusAction()
    {
        $section = $this->getUser()->getSection();

        $this->checkPermissionsForSection($section);

        return $this
            ->get('main.guide.service')
            ->changeStatus($section);
    }

    public function countAction()
    {
        return $this
            ->get('main.guide.fetcher')
            ->count();
    }
}
