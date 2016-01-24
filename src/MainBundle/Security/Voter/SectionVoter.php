<?php

namespace MainBundle\Security\Voter;

use MainBundle\Entity\Notification;
use MainBundle\Entity\Permission;
use MainBundle\Entity\Section;
use MainBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SectionVoter extends Voter
{
    // these strings are just invented: you can use anything
    const ACCESS = 'access';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::ACCESS))) {
            return false;
        }

        if (!$subject instanceof Section) {
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

    private function canAccess(Section $section, User $user)
    {
        return (
            $user->getSection()->getCodeSection() === $section->getCodeSection()
        ) || $user->hasRole(User::ROLE_ADMIN);
    }
}
