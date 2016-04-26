<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\Category;
use MainBundle\Entity\Guide;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = (new Category())
            ->setTitle("First Category")
            ->setContent("First Category content")
            ->setGuide($this->getReference("guideLILLE"))
            ->setPosition(0);

        $category2 = (new Category())
            ->setTitle("Second Category")
            ->setContent("Second Category content")
            ->setGuide($this->getReference("guideLILLE"))
            ->setPosition(1);

        $category3 = (new Category())
            ->setTitle("Third Category")
            ->setContent("Third Category content")
            ->setGuide($this->getReference("guideSection01"))
            ->setPosition(0);


        $this->addReference("guideLille-category1", $category1);
        $this->addReference("guideLille-category2", $category2);
        $this->addReference("guideSection01-category1", $category3);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
