<?php

namespace MainBundle\Adapter;

class RegIdAdapter
{
    public function getModels($regIds)
    {
        $regIdsArray = array();
        foreach ($regIds as $regId) {
            $regIdsArray[] = $regId->getId();
        }

        return $regIdsArray;
    }
}
