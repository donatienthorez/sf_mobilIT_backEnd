<?php

namespace MainBundle\Model;

use MainBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserModel extends User
{
    private $codeSection;

    /**
     * @return string
     */
    public function getCodeSection()
    {
        return $this->codeSection;
    }

    /**
     * @param $codeSection
     */
    public function setCodeSection($codeSection)
    {
        $this->codeSection = $codeSection;
    }
}
