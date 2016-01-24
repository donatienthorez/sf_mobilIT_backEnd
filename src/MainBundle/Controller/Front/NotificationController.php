<?php

namespace MainBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificationController extends Controller
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
