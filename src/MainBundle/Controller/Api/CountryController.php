<?php

namespace MainBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations as FosRest;
use JMS\Serializer\SerializationContext;

/**
 * @FosRest\NamePrefix("api_countries_")
 *
 * @Security("has_role('ROLE_USER')")
 */
class CountryController extends Controller
{
    public function getAction()
    {
        $countries = $this
            ->get('main.country.service')
            ->getCountries();

        return new Response(
            $this->get('serializer')->serialize(
                $countries,
                'json',
                SerializationContext::create()->setGroups(array('list'))
            )
        );
    }

    public function detailsAction()
    {
        $countries = $this
            ->get('main.country.service')
            ->getCountries();

        return new Response(
            $this->get('serializer')
                ->serialize(
                    $countries,
                    'json',
                    SerializationContext::create()->setGroups(array('Default', 'details'))
            )
        );
    }
}
