<?php

namespace MainBundle\Creator;

use MainBundle\Entity\RegId;

class RegIdCreator
{
    public function createRegId($id, $section)
    {
        return (new RegId())
            ->setId($id)
            ->setSection($section);
    }
}
