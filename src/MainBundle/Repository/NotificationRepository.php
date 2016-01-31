<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NotificationRepository extends EntityRepository
{

    /**
     * Returns the number of notifications
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
