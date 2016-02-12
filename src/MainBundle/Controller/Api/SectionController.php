<?php

namespace MainBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as FosRest;

/**
 * @Security("has_role('ROLE_USER')")
 * @FosRest\NamePrefix("api_sections_")
 */
class SectionController extends Controller
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
}
