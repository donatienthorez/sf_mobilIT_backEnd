<?php

namespace MainBundle\Controller\AndroidApi;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as FosRest;

/**
 * @FosRest\NamePrefix("api_android_countries_")
 */
class CountryController extends Controller
{
    public function getAction()
    {
        $countries = $this
            ->get('main.country.service')
            ->getCountries();

        $serializer = $this->get('serializer');
        return $serializer->serialize($countries, 'json', SerializationContext::create()->setGroups(array('list')));
    }
}
