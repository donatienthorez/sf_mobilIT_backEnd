<?php

namespace ESN\GalaxyLoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('esn_logged_redirection'));
        }
        return $this->redirect($this->generateUrl('esn_not_logged_redirection'));
    }

    public function logoutAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $this->get('activity.manager')->logout();
        $this->get("galaxy_user_bundle.user.provider")->logout();
        return $this->redirect($this->generateUrl('esn_not_logged_redirection'));
    }

    public function checkAction(Request $request)
    {
        try {
            $user = $this->get("galaxy_user_bundle.user.provider")->loadUser();

            $token = new UsernamePasswordToken(
              $user,
              null,
              "main",
              $user->getRoles()
            );

            $this->get("security.token_storage")->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirect($this->generateUrl('esn_logged_redirection'));

        } catch (AccessDeniedException $e) {
            return $this->redirect($this->generateUrl('esn_not_logged_redirection'));
        }
    }
}
