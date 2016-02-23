<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations as FosRest;
use JMS\Serializer\SerializationContext;
use MainBundle\Entity\Section;

/**
 * @FosRest\NamePrefix("api_android_sections_v1_")
 */
class SectionController extends Controller
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
    public function listAction(ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response("Invalid token. The token should be the same than the config file.", Response::HTTP_FORBIDDEN);
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
    public function listDetailsAction(ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response("Invalid token. The token should be the same than the config file.", Response::HTTP_FORBIDDEN);
        }

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
     * @FosRest\Get("/{section}/")
     * @ParamConverter("section", class="MainBundle:Section")
     *
     * @QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token"
     * )
     *
     * @FosRest\View()
     *
     * @return Response
     */
    public function getAction(Section $section, ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response("Invalid token. The token should be the same than the config file.", Response::HTTP_FORBIDDEN);
        }

        return new Response(
            $this
                ->get('serializer')
                ->serialize(
                    $section,
                    'json',
                    SerializationContext::create()->setGroups(array('details')
                    )
            )
        );
    }
}
