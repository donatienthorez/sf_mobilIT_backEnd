<?php

namespace MainBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomepageController extends Controller
{
  /**
   * @Route("/homepage", name="esn_not_logged_redirection")
   */
  public function indexAction()
  {
    return $this->render(
      'MainBundle::homepage.html.twig'
    );
  }
}
