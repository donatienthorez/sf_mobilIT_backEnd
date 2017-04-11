<?php

namespace MainBundle\Controller\Api\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use MainBundle\Security\Voter\SectionVoter;
use MainBundle\Security\Voter\CountryVoter;

class BaseController extends Controller
{
    public function checkPermissionsForSection($section)
    {
        if (!$this->isGranted(SectionVoter::ACCESS, $section)) {
            throw new AccessDeniedHttpException(
                "Only admins can perform this action."
            );
        }
    }
    public function checkPermissionsForCountry($country)
    {
        //TODO move this to the country voter
        $user = $this->getUser();

        $forbidden = !(($user->getSection()->getCountry()->getCodeCountry() === $country->getCodeCountry())
            || $user->hasRole(User::ROLE_ADMIN)
            || $user->hasRole(User::ROLE_BOARD_NATIONAL));

        if ($forbidden) {
            throw new AccessDeniedHttpException(
                "Only admins can perform this action."
            );
        }
    }
}
