<?php

namespace MainBundle\Adapter;

use MainBundle\Model\CategoryModel;
use MainBundle\Model\GuideModel;

class GuideAdapter
{

    /**
     * @param CategoryAdapter $categoryAdapter
     */
    public function __construct(
        CategoryAdapter $categoryAdapter
    ) {
        $this->categoryAdapter = $categoryAdapter;
    }

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
            if ($guide->getSection()) {
                $model->setCodeSection($guide->getSection()->getCodeSection());
            }
            $model->setActivated($guide->getActivated());
            foreach ($guide->getCategories() as $category) {
                if (!$category->getParent()) {
                    $categoryM = $this->categoryAdapter->getModel($category);
                    foreach ($category->getChildren() as $category2) {
                        $category2M = $this->categoryAdapter->getModel($category2);

                        foreach ($category2->getChildren() as $category3) {
                            $category3M = $this->categoryAdapter->getModel($category3);
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
            if ($guide->getSection()) {
                $model->setCodeSection($guide->getSection()->getCodeSection());
            }
            $model->setActivated($guide->getActivated());
        }

        return $model;
    }

    public function addCountryGuide(GuideModel $sectionGuide, GuideModel $countryGuide)
    {
        if (!$countryGuide->isActivated()) {
            return $sectionGuide;
        }

        if ($sectionGuide->isActivated()) {
            foreach ($sectionGuide->getNodes() as $categoryModel) {
                $countryGuide->addToNodes($categoryModel);
            }
        }

        return $countryGuide;
    }
}
