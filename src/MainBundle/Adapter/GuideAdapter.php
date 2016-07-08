<?php

namespace MainBundle\Adapter;

use MainBundle\Model\CategoryModel;
use MainBundle\Model\GuideModel;

class GuideAdapter
{
    /**
     * Gets the model of a Guide.
     *
     * @param $guide
     * @param $onlyActivated
     *   set contents only if activated.
     *
     * @return GuideModel
     */
    public function getModel($guide, $onlyActivated = false)
    {
        $model = new GuideModel();

        if (!$guide) {
            return $model->setCreated(false);

        }

        if (($onlyActivated && $guide->getActivated()) || (!$onlyActivated)) {
            $model->setCreated(true);
            $model->setCodeSection($guide->getSection()->getCodeSection());
            $model->setActivated($guide->getActivated());
            foreach ($guide->getCategories() as $category) {
                if (!$category->getParent()) {
                    $categoryM = (new CategoryModel())
                        ->setId($category->getId())
                        ->setTitle($category->getTitle())
                        ->setContent($category->getContent())
                        ->setPosition($category->getPosition())
                        ->setImage($category->getImage());
                    foreach ($category->getChildren() as $category2) {
                        $category2M = (new CategoryModel())
                            ->setId($category2->getId())
                            ->setTitle($category2->getTitle())
                            ->setContent($category2->getContent())
                            ->setPosition($category2->getPosition())
                            ->setImage($category->getImage());
                        foreach ($category2->getChildren() as $category3) {
                            $category3M = (new CategoryModel())
                                ->setId($category3->getId())
                                ->setTitle($category3->getTitle())
                                ->setContent($category3->getContent())
                                ->setPosition($category3->getPosition())
                                ->setImage($category->getImage());
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
        } else {
            $model->setCreated(true);
            $model->setCodeSection($guide->getSection()->getCodeSection());
            $model->setActivated($guide->getActivated());
        }

        return $model;
    }
}
