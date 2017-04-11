<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;
use MainBundle\Entity\Country;

class GuideCreator
{
    public function createGuideBySection(Section $section)
    {
        $guide = new Guide();
        $guide->setSection($section);

        return $guide;
    }
    public function createGuideByCountry(Country $country)
    {
        $guide = new Guide();
        $guide->setCountry($country);

        return $guide;
    }
}
