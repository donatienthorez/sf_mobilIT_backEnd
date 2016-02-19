<?php

namespace MainBundle\Model;

class GuideModel
{
    private $codeSection;
    private $activated;
    private $created;
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
        if ($this->nodes) {
            usort($this->nodes, array($this, "cmp"));
        }
    }

    function cmp(CategoryModel $a, CategoryModel $b)
    {
        $a = $a->getPosition();
        $b = $b->getPosition();

        return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
    }

    function setActivated($activated)
    {
        $this->activated = $activated;
    }

    function isActivated() {
        return $this->activated;
    }

    function setCreated($created){
        $this->created = $created;
    }
}
