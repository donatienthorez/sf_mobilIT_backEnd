<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @FosRest\NamePrefix("api_android_regids_v1_")
 */
class RegIdController extends Controller
{
    /**
     * @FosRest\View()
     * @FosRest\Post("/")
     *
     * @QueryParam(
     *     name = "token",
     *     nullable = false,
     *     description = "Mobilit token"
     * )
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     */
    public function createAction(Request $request, ParamFetcher $paramFetcher)
    {
        if ($this->container->getParameter('mobilit_token') != $paramFetcher->get('token')) {
            return new Response("Invalid token. The token should be the same than the config file.", Response::HTTP_FORBIDDEN);
        }

        $regId = $request->request->get('regId');
        $section = $request->request->get('section');

        if (!$regId || !$section) {
            return new Response("Invalid post arguments", Response::HTTP_BAD_REQUEST);
        }

        return $this
            ->get('main.regid.manager')
            ->saveRegId($regId, $section);
    }
}
