<?php

namespace MainBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SettingsController extends Controller
{
    /**
     * @Route("/admin/settings/", name="esn_settings")
     *
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Settings:index.html.twig');
    }
}
