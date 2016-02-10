<?php

namespace MainBundle\Controller\AndroidApi\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;

/**
 * @FosRest\NamePrefix("api_android_regids_")
 */
class RegIdController extends Controller
{
    /**
     * @FosRest\View()
     * @FosRest\Post("/")
     *
     * @QueryParam(
     *     name="regId",
     *     nullable=false,
     *     description="regId of the user"
     * )
     * @QueryParam(
     *     name="section",
     *     nullable=false,
     *     description="Esn section of the user"
     * )
     * @param ParamFetcher $paramFetcher
     *
     * @return \HttpInvalidParamException
     */
    public function createAction(ParamFetcher $paramFetcher)
    {
        $regId = $paramFetcher->get('regId');
        $section = $paramFetcher->get('section');

        if (!$regId || !$section) {
            return new \HttpInvalidParamException();
        }

        return $this
            ->get('main.regid.manager')
            ->saveRegId($regId, $section);
    }
}
