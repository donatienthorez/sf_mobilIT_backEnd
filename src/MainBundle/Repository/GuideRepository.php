<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;

class GuideRepository extends EntityRepository
{
    /**
     * Returns the number of notification
     *
     * @param Section $section
     *
     * @return Guide
     */
    public function getGuide(Section $section)
    {
        $query = $this
            ->createQueryBuilder('g')
            ->select('g')
            ->where('g.section = :section')
            ->setParameter(":section", $section->getCodeSection())
            ->getQuery();

        return $query->getSingleResult();
    }
}
