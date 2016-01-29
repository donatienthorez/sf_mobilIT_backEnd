<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GuideRepository extends EntityRepository
{

    /**
     * Returns the number of notification
     *
     * @return int
     */
    public function getGuide($section)
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
