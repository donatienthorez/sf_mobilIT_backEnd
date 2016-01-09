<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationsController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Notifications:index.html.twig');
    }
}
