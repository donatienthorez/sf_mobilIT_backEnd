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

    public function addChild(Category $category)
    {
        $createdCategory = $this
            ->categoryManager
            ->addChild($category);

        return $this
            ->categoryAdapter
            ->getModel($createdCategory);
    }

    public function add(Guide $guide)
    {
        $createdCategory = $this
            ->categoryManager
            ->add($guide);

        return $this
            ->categoryAdapter
            ->getModel($createdCategory);
    }

    public function edit(Category $category, $title, $content)
    {
        $category->setTitle($title)->setContent($content);
        $this
            ->categoryManager
            ->edit($category);
    }

    public function move(Category $category, $parentId, $position)
    {
        $this
            ->categoryManager
            ->move($category, $parentId, $position);
    }

    public function removeCategory(Category $category)
    {
        $this
            ->categoryManager
            ->removeCategory($category);
    }
}
