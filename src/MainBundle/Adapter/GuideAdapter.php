<?php

namespace MainBundle\Adapter;

use MainBundle\Model\CategoryModel;
use MainBundle\Model\GuideModel;

class GuideAdapter
{
    public function getModel($guide)
    {
        $model = new GuideModel();
        $model->setCodeSection($guide->getSection()->getCodeSection());
        foreach ($guide->getCategories() as $category) {
            if (!$category->getParent()) {
                $categoryM = (new CategoryModel())
                    ->setId($category->getId())
                    ->setTitle($category->getTitle())
                    ->setContent($category->getContent())
                    ->setPosition($category->getPosition());
                foreach ($category->getChildren() as $category2) {
                    $category2M = (new CategoryModel())
                        ->setId($category2->getId())
                        ->setTitle($category2->getTitle())
                        ->setContent($category2->getContent())
                        ->setPosition($category2->getPosition());

                    foreach ($category2->getChildren() as $category3) {
                        $category3M = (new CategoryModel())
                            ->setId($category->getId())
                            ->setTitle($category3->getTitle())
                            ->setContent($category3->getContent())
                            ->setPosition($category3->getPosition());
                        $category2M->addToNodes($category3M);
                    }
                    $categoryM->addToNodes($category2M);
                    $category2M->sortNodes();
                }
                $model->addToNodes($categoryM);
                $categoryM->sortNodes();
            }
            $model->sortNodes();
        }
        return $model;
    }
}
