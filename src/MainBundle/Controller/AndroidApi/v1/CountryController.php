<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @FosRest\NamePrefix("api_android_countries_v1_")
 */
class CountryController extends Controller
{
    /**
     * @FosRest\Get("")
     *
     * @ApiDoc(
     *  description = "List all the countries and their sections."
     * )
     *
     * @FosRest\QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token."
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     */
    public function listAction(ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response(
                json_encode(["message" => "Invalid token. The token should be the same than the config file."]),
                Response::HTTP_FORBIDDEN
            );
        }

        $countries = $this
            ->get('main.country.service')
            ->getCountries(true);

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
