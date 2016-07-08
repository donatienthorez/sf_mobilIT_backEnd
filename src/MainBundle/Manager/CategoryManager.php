<?php

namespace MainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Category;
use MainBundle\Entity\Guide;

class CategoryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    /**
     * @param Category $c parent of the new category
     *
     * @return Category category created
     */
    public function addChild(Category $c)
    {
        $category = new Category();
        $category
            ->setPosition($c->getMaxPosition()+1)
            ->setParent($c)
            ->setGuide($c->getGuide())
            ->setTitle("New Category");

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    /**
     * @param Guide $guide
     *
     * @return Category category created
     *
     */
    public function add(Guide $guide)
    {
        $category = new Category();
        $category
            ->setParent(null)
            ->setGuide($guide)
            ->setTitle("New Category")
            ->setPosition($guide->getMaxPosition() == 0 ? 0 : $guide->getMaxPosition()+1)
            ->setImage(null);

        $guide->addCategory($category);

        $this->em->persist($guide);
        $this->em->flush();

        return $category;
    }

    public function move(Category $category, $parentId, $newPosition)
    {
        if ($parentId) {
            $parentCategory = $this
                ->em
                ->find('MainBundle:Category', $parentId);
            $newSiblings = $parentCategory
                ->getChildren();
        } else {
            $guide = $category->getGuide();
            $newSiblings = $guide->getCategoriesWithoutParent();
        }
        $oldPosition = $category->getPosition();

        // if we just move the position
        if (($category->getParent() == null && $parentId == null)
            || ($category->getParent() != null && $category->getParent()->getId() == $parentId)
        ) {
            if ($oldPosition > $newPosition) {
                foreach ($newSiblings as $child) {
                    if ($child->getPosition() >= $newPosition && $child->getPosition() < $oldPosition) {
                        $child->setPosition($child->getPosition() + 1);
                    }
                    $this->em->persist($child);
                }
            } else {
                foreach ($newSiblings as $child) {
                    if ($child->getPosition() <= $newPosition && $child->getPosition() > $oldPosition) {
                        $child->setPosition($child->getPosition() -1);
                    }
                    $this->em->persist($child);
                }
            }
        } // if we move the position and change the parent
        else {
            $oldSiblings = $category->getParent() ?
                $category->getParent()->getChildren()
                : $category->getGuide()->getCategoriesWithoutParent();

            foreach ($oldSiblings as $child) {
                if ($child->getPosition() >= $oldPosition) {
                    $child->setPosition($child->getPosition() - 1);
                }
                $this->em->persist($child);
            }
            foreach ($newSiblings as $child) {
                if ($child->getPosition() >= $newPosition) {
                    $child->setPosition($child->getPosition() + 1);
                }
                $this->em->persist($child);
            }
        }

        $category
            ->setPosition($newPosition);

        if (isset($parentCategory)) {
            $category->setParent($parentCategory);
        } else {
            $category->setParent(null);
        }

        $this
            ->em
            ->persist($category);
        $this->em->flush();
    }

    public function edit(Category $c)
    {
        $this
            ->em
            ->persist($c);
        $this
            ->em
            ->flush();
    }

    public function removeCategory(Category $category)
    {
        $oldSiblings = $category->getParent() ?
            $category->getParent()->getChildren()
            : $category->getGuide()->getCategoriesWithoutParent();
        foreach ($oldSiblings as $child) {
            if ($child->getPosition() >= $category->getPosition()) {
                $child->setPosition($child->getPosition() - 1);
            }
            $this->em->persist($child);
        }

        $this
            ->em
            ->remove($category);
        $this
            ->em
            ->flush();
    }
}
