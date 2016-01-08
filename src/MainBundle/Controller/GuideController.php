<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuideController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Guide:index.html.twig');
    }
}
