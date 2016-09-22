<?php

namespace MainBundle\Adapter;

use MainBundle\Entity\Category;
use MainBundle\Model\CategoryModel;

class CategoryAdapter
{
    public function getModel(Category $category)
    {
        return (new CategoryModel())
            ->setId($category->getId())
            ->setPosition($category->getPosition())
            ->setTitle($category->getTitle())
            ->setImage($category->getImage())
            ->setContent($category->getContent());
    }
}
