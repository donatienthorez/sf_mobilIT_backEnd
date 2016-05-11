<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;

class GuideRepository extends EntityRepository
{
    /**
     * Returns the guide of the section.
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
            ->setParameter(":section", $section->getCodeSection());

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Returns the number of guides
     *
     * @return int
     */
    public function count()
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

}
