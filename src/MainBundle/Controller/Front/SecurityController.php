<?php

namespace MainBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/", name="esn_login_homepage")
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('esn_guide'));
        }
        return $this->render('MainBundle::homepage.html.twig');
    }

    /**
     * @Route("/login_check", name="esn_login_check")
     */
    public function checkAction(Request $request)
    {
        $userCas = $this->get("main.user.provider")->loadUser();

        if ($userCas != null) {

            $user_db = $this
                ->get("main.user.manager")
                ->saveUser($userCas);

            $token = new UsernamePasswordToken(
                $user_db,
                null,
                "main",
                $user_db->getRoles()
            );

            $this->get("security.token_storage")->setToken($token);

            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirect($this->generateUrl('esn_guide'));
        }
        return $this->redirect($this->generateUrl('esn_login_homepage'));
    }

    /**
     * @Route("/logout", name="esn_logout")
     */
    public function logoutAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $this->get('activity.manager')->logout();
        return $this->redirect($this->generateUrl('esn_login_homepage'));
    }
}
