<?php

namespace MainBundle\Service;

use MainBundle\Adapter\CategoryAdapter;
use MainBundle\Entity\Category;
use MainBundle\Entity\Guide;
use MainBundle\Manager\CategoryManager;

class CategoryService
{
    /**
     * @var CategoryManager
     */
    private $categoryManager;

    /**
     * @var CategoryAdapter
     */
    private $categoryAdapter;

    /**
     * @param CategoryManager $categoryManager
     * @param CategoryAdapter $categoryAdapter
     */
    public function __construct(
        CategoryManager $categoryManager,
        CategoryAdapter $categoryAdapter
    ) {
        $this->categoryManager = $categoryManager;
        $this->categoryAdapter = $categoryAdapter;
    }

    public function addChild(Category $c)
    {
        $createdCategory = $this
            ->categoryManager
            ->addChild($c);

        return $this
            ->categoryAdapter
            ->getModel($createdCategory);
    }

    public function add(Guide $g)
    {
        $createdCategory = $this
            ->categoryManager
            ->add($g);

        return $this
            ->categoryAdapter
            ->getModel($createdCategory);
    }

    public function move(Category $category, $parentId, $position)
    {
        $this
            ->categoryManager
            ->move($category, $parentId, $position);
    }

    public function removeCategory(Category $c)
    {
        $this
            ->categoryManager
            ->removeCategory($c);
    }
}
