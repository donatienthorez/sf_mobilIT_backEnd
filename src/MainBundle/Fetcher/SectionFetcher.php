<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;

class SectionFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getSections()
    {
        return $this
            ->em
            ->getRepository('MainBundle:Section')
            ->findAll();
    }

    public function getSection($codeSection)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Section')
            ->find($codeSection);
    }

    public function checkSectionToken(Section $section, $token)
    {
        return $this
            ->em
            ->getRepository('MainBundle:Section')
            ->findOneBy(array(
                'codeSection' => $section->getCodeSection(),
                'token' => $token
            ));
    }
}
