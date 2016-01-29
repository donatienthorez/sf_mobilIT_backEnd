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
            $categoryM = new CategoryModel();
            $categoryM->setTitle($category->getTitle());
            $categoryM->setContent($category->getContent());
            $categoryM->setPosition($category->getPosition());
            foreach ($category->getChildren() as $category2) {
                $category2M = (new CategoryModel())
                    ->setTitle($category2->getTitle())
                    ->setContent($category2->getContent())
                    ->setPosition($category2->getPosition());

                foreach ($category2->getChildren() as $category3) {
                    $category3M = (new CategoryModel())
                        ->setTitle($category3->getTitle())
                        ->setContent($category3->getContent())
                        ->setPosition($category3->getPosition());
                    $category2M->addToNodes($category3M);
                    $category2M->sortNodes();
                }
                $categoryM->addToNodes($category2M);
                $categoryM->sortNodes();
            }
            $model->addToNodes($categoryM);
            $model->sortNodes();
        }
        return $model;
    }
}
