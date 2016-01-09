<?php

namespace MainBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuideController extends Controller
{
    /**
     * @Route("/admin/guide/", name="esn_guide")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Guide:index.html.twig');
    }
}
