<?php

namespace MainBundle\Model;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use MainBundle\Entity\User;

class CategoryModel
{
    private $id;
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
        if ($this->nodes != null) {
            usort($this->nodes, array($this, "cmp"));
        }
    }

    function cmp(CategoryModel $a, CategoryModel $b)
    {
        $a = $a->getPosition();
        $b = $b->getPosition();

        return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     *
     * @return $this
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
     *
     * @return $this
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
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
