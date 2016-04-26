<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FosRest;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use MainBundle\Entity\Section;

/**
 * @FosRest\NamePrefix("api_android_sections_v1_")
 */
class SectionController extends Controller
{
    /**
     * @FosRest\Get("")
     *
     * @ApiDoc(
     *  description = "List all the sections."
     * )
     *
     * @FosRest\QueryParam(
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
            return new Response(
                json_encode(["message" => "Invalid token. The token should be the same than the config file."]),
                Response::HTTP_FORBIDDEN
            );
        }

        $sections = $this
            ->get('main.section.service')
            ->getSections();

        $serializer = $this->get('serializer');

        return new Response(
            $serializer->serialize(
                $sections,
                'json',
                SerializationContext::create()->setGroups(array('Default', 'details'))
            )
        );
    }

    /**
     * @FosRest\Get("/{section}")
     *
     * @ApiDoc(
     *  description = "Get the details of a section."
     * )
     *
     * @ParamConverter("section", class="MainBundle:Section")
     *
     * @FosRest\QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token."
     * )
     *
     * @param Section $section
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     */
    public function getAction(Section $section, ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response(
                "Invalid token. The token should be the same than the config file.",
                Response::HTTP_FORBIDDEN
            );
        }

        return new Response(
            $this
                ->get('serializer')
                ->serialize(
                    $section,
                    'json',
                    SerializationContext::create()->setGroups(array('details'))
                )
        );
    }
}
