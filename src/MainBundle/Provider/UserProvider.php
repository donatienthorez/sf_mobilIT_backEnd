<?php

namespace MainBundle\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use phpCAS;
use MainBundle\Security\User;

class UserProvider implements UserProviderInterface
{
    private $cas_server;
    private $cas_port;
    private $cas_path;

    public function __construct($cas_server, $cas_port, $cas_path)
    {
        $this->cas_server = $cas_server;
        $this->cas_port = $cas_port;
        $this->cas_path = $cas_path;
    }

    public function loadUser()
    {
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $this->cas_server, $this->cas_port, $this->cas_path, false);
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();
        $username =  phpCAS::getUser();
        if ($username) {
            $attributes = phpCAS::getAttributes();
            return new User($username, $attributes, null, null, array());
        }
    }

    public function loadUserByUsername($username)
    {
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $this->cas_server, $this->cas_port, $this->cas_path);
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();
        $username =  phpCAS::getUser();
        if ($username) {
            $attributes = phpCAS::getAttributes();
            return new User($username, $attributes, null, null, array());
        }
        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
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
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
        phpCAS::logout();
        return true;
    }

    public function supportsClass($class)
    {
        return $class === 'ESN\LoginBundle\Security\User\UserProvider';
    }
}
