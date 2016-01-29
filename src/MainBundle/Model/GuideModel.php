<?php

namespace MainBundle\Model;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use MainBundle\Entity\User;

class GuideModel
{
    private $codeSection;
    private $nodes;

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

    public function addToNodes(CategoryModel $cm)
    {
        $this->nodes[$cm->getPosition()] = $cm;
    }

    public function sortNodes(){
        usort($this->nodes, array($this, "cmp"));
    }

    function cmp(CategoryModel $a, CategoryModel $b)
    {
        return strcmp($a->getPosition(), $b->getPosition());
    }
}
