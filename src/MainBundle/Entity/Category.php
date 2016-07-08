<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @ExclusionPolicy("all")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="text")
     * @Expose
     */
    protected $title;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Expose
     */
    protected $content;

    /**
     * @ORM\Column(name="createAt", type="datetime")
     * @Expose
     */
    protected $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="Guide", inversedBy="categories")
     * @ORM\JoinColumn(name="guide", referencedColumnName="id")
     */
    protected $guide;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"all"})
     */
    private $children;

    /**
     * @ORM\Column(name="position", type="integer")
     * @Expose
     */
    protected $position;

    /**
     * @ORM\Column(name="image", type="text", nullable=true)
     * @Expose
     */
    protected $image;

    public function __construct()
    {
        $this->createAt = new \DateTime();
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
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

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
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     *
     * @return $this
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Guide
     */
    public function getGuide()
    {
        return $this->guide;
    }

    /**
     * @param Guide $guide
     *
     * @return $this
     */
    public function setGuide(Guide $guide)
    {
        $this->guide = $guide;

        return $this;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function addChildren($children)
    {
        array_push($this->children, $children);
    }

    public function removeChildren($children)
    {
        unset($this->children, $children);
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }


    /**
     * @return int
     */
    public function getMaxPosition()
    {
        $max = 0;
        foreach ($this->getChildren() as $children) {
            $max = max($children->getPosition(), $max);
        }
        return $max;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}
