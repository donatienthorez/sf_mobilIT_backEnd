<?php

namespace MainBundle\Creator;

use MainBundle\Entity\RegId;

class RegIdCreator
{
    public function createRegId($id, $section)
    {
        $regId = new RegId();
        $regId->setId($id);
        $regId->setSection($section);


        return $regId;
    }
}
