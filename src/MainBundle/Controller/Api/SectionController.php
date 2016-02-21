<?php

namespace MainBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as FosRest;
use MainBundle\Controller\Api\Base\BaseController;
use MainBundle\Entity\Section;

/**
 * @Security("has_role('ROLE_USER')")
 * @FosRest\NamePrefix("api_sections_")
 */
class SectionController extends BaseController
{
    public function getAction()
    {
        $countries = $this
            ->get('main.section.service')
            ->getSections();

        return new Response(
            $this->get('serializer')
                ->serialize(
                    $countries,
                    'json',
                    SerializationContext::create()->setGroups(array('listSection'))
            )
        );
    }

    public function detailsAction()
    {
        $countries = $this
            ->get('main.section.service')
            ->getSections();

        $serializer = $this->get('serializer');

        return new Response(
            $serializer->serialize(
                $countries,
                'json',
                SerializationContext::create()->setGroups(array('Default', 'details'))
            )
        );
    }

    /**
     * @FosRest\Get("/user")
     *
     * @FosRest\View()
     *
     * @return Response
     */
    public function getOfUserAction()
    {
        $section = $this
            ->getUser()
            ->getSection();

        return new Response(
            $this
                ->get('serializer')
                ->serialize(
                    $section,
                    'json',
                    SerializationContext::create()->setGroups(array('token', 'details'))
                )
            );
    }

    /**
     * @FosRest\Post("/{section}/generateToken")
     * @ParamConverter("section", class="MainBundle:Section")
     *
     * @FosRest\View()
     *
     * @return Response
     */
    public function generateTokenAction(Section $section)
    {
        return $this
            ->get('main.section.service')
            ->generateToken($section);
    }
}
