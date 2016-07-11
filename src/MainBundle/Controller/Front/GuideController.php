<?php

namespace MainBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GuideController extends Controller
{
    /**
     * @Route("/admin/guide/", name="esn_guide")
     */
    public function indexAction()
    {
        return $this->render(
            'MainBundle:Guide:index.html.twig'
        );
    }

    /**
     * @Route("/admin/guide/", name="esn_logged_redirection")
     */
    public function loggedAction()
    {
        return $this->render(
          'MainBundle:Guide:index.html.twig'
        );
    }
}
