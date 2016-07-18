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
     * @var UploadService
     */
    private $uploadService;

    /**
     * @var string
     */
    private $siteUrl;

    /**
     * @param CategoryManager $categoryManager
     * @param CategoryAdapter $categoryAdapter
     * @param UploadService   $uploadService
     */
    public function __construct(
        CategoryManager $categoryManager,
        CategoryAdapter $categoryAdapter,
        UploadService $uploadService,
        $siteUrl
    ) {
        $this->categoryManager = $categoryManager;
        $this->categoryAdapter = $categoryAdapter;
        $this->uploadService = $uploadService;
        $this->siteUrl = $siteUrl;
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

    public function edit(Category $category, $title, $content, $image)
    {
        if ($image) {
            $fileName = sprintf("%s.%s", $category->getId(), $image->guessExtension());
            $filePath =  'uploads/images/categories/';

            if ($category->getImage()) {
                $this->uploadService->deleteFile(
                  str_replace($this->siteUrl, '', $category->getImage())
                );
            }

            $this->uploadService->uploadFile($image, $fileName, $filePath);

            $imageSitePath = sprintf("%s%s%s", $this->siteUrl, $filePath, $fileName);
            $category->setImage($imageSitePath);
        }

        $category->setTitle($title);
        $category->setContent($content ? $content : "");

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
        $this->uploadService->deleteFile($category->getImage());
        $this
            ->categoryManager
            ->removeCategory($category);
    }

    public function deleteImage(Category $category)
    {
        $this->uploadService->deleteFile($category->getImage());
        $category->setImage(null);

        $this
          ->categoryManager
          ->edit($category);
    }
}
