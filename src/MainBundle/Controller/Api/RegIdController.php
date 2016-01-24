<?php

namespace MainBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FosRest;

/**
 * @FosRest\NamePrefix("api_regids_")
 */
class RegIdController extends Controller
{
    public function countAction()
    {
        return
            $this
            ->get('main.regid.fetcher')
            ->count();
    }
}
