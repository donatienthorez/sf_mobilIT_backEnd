<?php

namespace MainBundle\Model;

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
        $this->nodes[] = $cm;
    }

    public function sortNodes(){
        usort($this->nodes, array($this, "cmp"));
    }

    function cmp(CategoryModel $a, CategoryModel $b)
    {
        $a = $a->getPosition();
        $b = $b->getPosition();

//        if($a == null) var_dump($a);
//        if($b == null) var_dump($b);

        return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
    }
}
