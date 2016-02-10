<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;

class GuideCreator
{
    public function createGuide(Section $section)
    {
        $guide = new Guide();
        $guide->setSection($section);

        return $guide;
    }
}
