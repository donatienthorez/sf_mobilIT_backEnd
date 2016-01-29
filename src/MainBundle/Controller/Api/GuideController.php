<?php

namespace MainBundle\Controller\Api;

use MainBundle\Model\CategoryModel;
use MainBundle\Model\GuideModel;
use MainBundle\Security\Voter\SectionVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as FosRest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @FosRest\NamePrefix("api_guides_")
 */
class GuideController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @FosRest\View()
     * @QueryParam(
     *     name="section",
     *     nullable=true,
     *     default=null,
     *     description="Esn section of the guide",
     * )
     */
    public function getAction($section = null)
    {
        $section =
            $section ?
                $this
                    ->get('main.section.fetcher')
                    ->getSection($section)
                : $this->getUser()->getSection();

        if (!$this->isGranted(SectionVoter::ACCESS, $section)) {
            throw new AccessDeniedHttpException('Only admins can see other sections than theirs');
        }

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        return $this
            ->get('main.guide.adapter')
            ->getModel($guide);
    }
}