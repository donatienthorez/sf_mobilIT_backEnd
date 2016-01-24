<?php

namespace MainBundle\Controller\AndroidApi;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;

/**
 * @FosRest\NamePrefix("api_android_regids_")
 */
class RegIdController extends Controller
{
    /**
     * @FosRest\View()
     * @FosRest\Post()
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
     *
     */
    public function createAction()
    {


    }
}