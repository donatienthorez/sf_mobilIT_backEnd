<?php

namespace ESN\GalaxyLoginBundle\Provider;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use phpCAS;
use MainBundle\Entity\User;
use MainBundle\Creator\UserCreator;


class GalaxyUserProvider implements UserProviderInterface
{
  private $casServer;
  private $casPort;
  private $casPath;

  /**
   * @var UserCreator
   */
  private $userCreator;

  public function __construct($cas_server, $cas_port, $cas_path, UserCreator $userCreator)
  {
    $this->casServer = $cas_server;
    $this->casPort = $cas_port;
    $this->casPath = $cas_path;
    $this->userCreator = $userCreator;
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

    $user = $this
      ->userCreator
      ->createUser(
        $username,
        $attributes['mail'],
        $attributes['roles'],
        $attributes['first'],
        $attributes['last'],
        $attributes['sc']
      );

    return $user;
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof User) {
      throw new UnsupportedUserException(
        sprintf('Instances of "%s" are not supported.', get_class($user))
      );
    }
    return $this->loadUserByUsername($user->getUsername());
  }

  public function logout($cas_host, $cas_port, $cas_context)
  {
    $this->initPHPCasConnection();
    phpCAS::logout();
    return true;
  }

  public function supportsClass($class)
  {
    return $class === 'MainBundle\Security\User\UserProvider';
  }
}
