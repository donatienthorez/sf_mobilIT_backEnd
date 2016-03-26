<?php

namespace MainBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SectionController extends Controller
{
    /**
     * @Route("/admin/sections/", name="esn_sections")
     *
     */
    public function indexAction()
    {
        return $this->render(
            'MainBundle:Section:index.html.twig'
        );

    }
}
