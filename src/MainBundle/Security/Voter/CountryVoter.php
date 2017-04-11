<?php

namespace MainBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Permission;
use MainBundle\Entity\Country;
use MainBundle\Entity\User;

class CountryVoter extends Voter
{
    const ACCESS = 'access';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::ACCESS))) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::ACCESS:
                return $this->canAccess($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }
    private function canAccess($country, User $user)
    {
        return (
            $user->getSection()->getCountry()->getCodeCountry() === $country->getCodeCountry()
        ) || $user->hasRole(User::ROLE_ADMIN);
    }
}
