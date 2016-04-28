<?php

namespace MainBundle\Fetcher;

use Doctrine\ORM\EntityManagerInterface;
use MainBundle\Entity\Section;

class SectionFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get all the sections.
     *
     * @return array
     */
    public function getSections($activated = false)
    {
        return $this
            ->entityManager
            ->getRepository('MainBundle:Section')
            ->findAllActivated($activated);
    }

    /**
     * Get one section by its codeSection.
     *
     * @param $codeSection
     *
     * @return Section
     */
    public function getSection($codeSection)
    {
        return $this
            ->entityManager
            ->getRepository('MainBundle:Section')
            ->find($codeSection);
    }

    /**
     * Check the token for a section.
     *
     * @param Section $section
     * @param $token
     *
     * @return Section
     */
    public function checkSectionToken(Section $section, $token)
    {
        return $this
            ->entityManager
            ->getRepository('MainBundle:Section')
            ->findOneBy(array(
                'codeSection' => $section->getCodeSection(),
                'token' => $token
            ));
    }
}
