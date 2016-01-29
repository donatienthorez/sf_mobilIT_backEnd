<?php

namespace MainBundle\Model;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use MainBundle\Entity\User;

class CategoryModel
{
    private $title;
    private $content;
    private $nodes;
    private $position;

    function __construct()
    {
        $this->nodes = array();
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
        return strcmp($a->getPosition(), $b->getPosition());
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
