<?php

namespace MainBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationsController extends Controller
{
    /**
     * @Route("/admin/notifications/", name="esn_notifications")
     *
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Notifications:index.html.twig');
    }
}
