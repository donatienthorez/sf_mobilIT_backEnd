<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SectionRepository extends EntityRepository
{
    /**
     * Returns the countries that have activated sections or all the sections.
     *
     * @param bool $onlyActivated
     *
     * @return array
     */
    public function findAllActivated($onlyActivated = false)
    {
        return $onlyActivated ?
            $this
                ->createQueryBuilder('s')
                ->select('s')
                ->where('s.activated = 1')
                ->orderBy('s.name', 'ASC')
                ->getQuery()
                ->getResult()
            : $this->findAll();
    }
}
