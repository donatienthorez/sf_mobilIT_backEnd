<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Guide;
use MainBundle\Entity\Section;

class GuideCreator
{
    public function createGuide(Section $section)
    {
        return (new Guide())->setSection($section);
    }
}
