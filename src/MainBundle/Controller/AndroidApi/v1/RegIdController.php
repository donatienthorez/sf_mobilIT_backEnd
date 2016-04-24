<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FosRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @FosRest\NamePrefix("api_android_regids_v1_")
 */
class RegIdController extends Controller
{
    /**
     * @FosRest\Post("")
     *
     * @ApiDoc(
     *  description = "Create or update regId.",
     *  parameters={
     *   {"name"="token", "dataType"="string", "required"=true, "description"="Mobilit token of the application."},
     *   {"name"="regId", "dataType"="string", "required"=true, "description"="RegId to save."},
     *   {"name"="section", "dataType"="string", "required"=true, "description"="CodeSection of the user section."},
     *  },
     * )
     *
     * @FosRest\RequestParam(name="token", description="Mobilit token of the application.", nullable=false)
     * @FosRest\RequestParam(name="regId", description="RegId to save.", nullable=false)
     * @FosRest\RequestParam(name="section", description="CodeSection of the user section.", nullable=false)
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        if ($this->container->getParameter('mobilit_token') != $request->request->get('token')) {
            return new Response(
                "Invalid token. The token should be the same than the config file.",
                Response::HTTP_FORBIDDEN
            );
        }

        return $this
            ->get('main.regid.manager')
            ->saveRegId(
                $request->request->get('regId'),
                $request->request->get('section')
            );
    }
}
