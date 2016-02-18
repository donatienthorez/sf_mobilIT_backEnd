<?php

namespace MainBundle\Controller\AndroidApi\v1;

use HttpInvalidParamException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
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
     * @return \HttpInvalidParamException
     */
    public function createAction(Request $request)
    {
        $regId = $request->request->get('regId');
        $section = $request->request->get('section');

        if (!$regId || !$section) {
            return new BadRequestHttpException();
        }

        return $this
            ->get('main.regid.manager')
            ->saveRegId($regId, $section);
    }
}
