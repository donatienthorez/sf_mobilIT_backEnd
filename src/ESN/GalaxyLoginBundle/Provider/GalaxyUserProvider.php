<?php

namespace ESN\GalaxyLoginBundle\Provider;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use phpCAS;
use ESN\GalaxyLoginBundle\Manager\UserManager;
use ESN\GalaxyLoginBundle\Entity\GalaxyUser;


class GalaxyUserProvider implements UserProviderInterface
{
  private $casServer;
  private $casPort;
  private $casPath;

  /**
   * @var UserManager
   */
  private $userManager;

  public function __construct($cas_server, $cas_port, $cas_path, UserManager $userManager)
  {
    $this->casServer = $cas_server;
    $this->casPort = $cas_port;
    $this->casPath = $cas_path;
    $this->userManager = $userManager;
  }

  public function initPHPCasConnection(){
    phpCAS::setDebug();
    phpCAS::client(CAS_VERSION_2_0, $this->casServer, $this->casPort, $this->casPath, false);
    phpCAS::setNoCasServerValidation();
    phpCAS::forceAuthentication();
  }

  public function loadUser(){
    $this->initPHPCasConnection();
    $username =  phpCAS::getUser();

    if (!$username) {
      throw new AccessDeniedHttpException();
    }
    return $this->loadUserByUsername($username);
  }

  public function loadUserByUsername($username)
  {
    $attributes = phpCAS::getAttributes();

    return $this->userManager->saveUser($username, $attributes);
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof GalaxyUser) {
      throw new UnsupportedUserException(
        sprintf('Instances of "%s" are not supported.', get_class($user))
      );
    }
    return $this->loadUserByUsername($user->getUsername());
  }

  public function logout()
  {
    $this->initPHPCasConnection();
    phpCAS::logout();
    return true;
  }

  public function supportsClass($class)
  {
    return $class === 'MainBundle\Security\User\UserProvider';
  }

  public function saveUser() {

  }

}
