<?php

namespace MainBundle\Adapter;

use MainBundle\Entity\Category;
use MainBundle\Model\CategoryModel;

class CategoryAdapter
{
    public function getModel(Category $c)
    {
        return (new CategoryModel())
            ->setId($c->getId())
            ->setPosition($c->getPosition())
            ->setTitle($c->getTitle())
            ->setContent($c->getContent());
    }
}
