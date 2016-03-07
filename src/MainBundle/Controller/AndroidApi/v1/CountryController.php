<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use JMS\Serializer\SerializationContext;

/**
 * @FosRest\NamePrefix("api_android_countries_")
 */
class CountryController extends Controller
{
    /**
     * @QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token"
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     */
    public function getAction(ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response(
                "Invalid token. The token should be the same than the config file.",
                Response::HTTP_FORBIDDEN
            );
        }

        $countries = $this
            ->get('main.country.service')
            ->getCountries();

        $serializer = $this->get('serializer');

        return new Response(
            $serializer->serialize(
                $countries,
                'json',
                SerializationContext::create()->setGroups(array('listSection'))
            )
        );
    }
}
