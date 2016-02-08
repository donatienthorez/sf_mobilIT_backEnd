<?php

namespace MainBundle\Controller\Api\Base;

use MainBundle\Security\Voter\SectionVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BaseController extends Controller
{
    public function checkPermissionsForSection($section) {
        if (!$this->isGranted(SectionVoter::ACCESS, $section)) {
            throw new AccessDeniedHttpException(
                "Only admins can perform this action."
            );
        }
    }
}