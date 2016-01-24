<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RegIdRepository extends EntityRepository
{
    /**
     * Returns the number of mobile users registered
     *
     * @return int
     */
    public function count()
    {
        $query = $this
            ->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}
