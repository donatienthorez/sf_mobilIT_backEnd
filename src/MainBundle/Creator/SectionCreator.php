<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Country;
use MainBundle\Entity\Section;

class SectionCreator
{
    public function createSection($codeSection, $name, $informations, Country $country)
    {
        $section = new Section();
        $section->setCodeSection($codeSection);
        $section->setName($name);
        $section->setAddress(isset($informations[0]) ? $informations[0] : null);
        $section->setPhone(isset($informations[1]) ? $informations[1] : null);
        $section->setWebsite(isset($informations[2]) ? $informations[2] : null);
        $section->setEmail(isset($informations[3]) ? $informations[3] : null);
        $section->setUniversity(isset($informations[4]) ? $informations[4] : null);
        $section->setCountry($country);

        return $section;
    }
}
