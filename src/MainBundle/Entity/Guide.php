<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="MainBundle\Repository\GuideRepository")
 * @ORM\Table(name="guides")
 * @ExclusionPolicy("all")
 *
 */
class Guide
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Section")
     * @ORM\JoinColumn(name="section", referencedColumnName="codeSection", unique=true)
     */
    protected $section;

    /**
     * @ORM\Column(name="createdAt", type="datetime")
     * @Expose
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Category", cascade="all", mappedBy="guide")
     * @Expose
     */
    protected $categories;

    /**
     * @ORM\Column(type="boolean", name="activated", options={"default": false})
     * @Expose
     */
    protected $activated;

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
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
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
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    public function getCategoriesWithoutParent()
    {
        $categories = [];
        foreach ($this->getCategories() as $children) {
            if (!$children->getParent()) {
                $categories[] = $children;
            }
        }
        return $categories;
    }

    public function getMaxPosition()
    {
        $max = 0;
        foreach ($this->getCategoriesWithoutParent() as $children) {
            $max = max($children->getPosition(), $max);
        }
        return $max;
    }
}
