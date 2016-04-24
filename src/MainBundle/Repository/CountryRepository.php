<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CountryRepository extends EntityRepository
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
                ->createQueryBuilder('c')
                ->select('c, s')
                ->join('c.sections','s')
                ->where('s.activated = 1')
                ->getQuery()
                ->getResult()
            : $this->findAll();
    }
}
