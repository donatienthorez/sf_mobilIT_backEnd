<?php

namespace MainBundle\Service;

use MainBundle\Creator\SectionCreator;
use MainBundle\Entity\Section;
use MainBundle\Fetcher\SectionFetcher;
use MainBundle\Manager\SectionManager;
use Symfony\Component\HttpFoundation\Request;

class SectionService
{
    /**
     * @var SectionFetcher
     */
    private $sectionFetcher;
    /**
     * @var SectionManager
     */
    private $sectionManager;

    /**
     * @param SectionFetcher $sectionFetcher
     * @param SectionManager $sectionManager
     */
    public function __construct(
        SectionFetcher $sectionFetcher,
        SectionManager $sectionManager
    ) {
        $this->sectionFetcher = $sectionFetcher;
        $this->sectionManager = $sectionManager;
    }

    public function getSections()
    {
        $data = $this
            ->sectionFetcher
            ->getSections();

        return $data;
    }

    public function editSection(Section $section, Request $request)
    {
        $name = $request->request->get('name');
        $website = $request->request->get('website');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $university = $request->request->get('university');
        $address = $request->request->get('address');
        $logoUrl = $request->request->get('logo_url');

        $section
            ->setName($name)
            ->setWebsite($website)
            ->setEmail($email)
            ->setPhone($phone)
            ->setUniversity($university)
            ->setAddress($address)
            ->setLogoUrl($logoUrl);

        $this
            ->sectionManager
            ->save($section);

        return $section;
    }

    public function generateToken(Section $section)
    {
        $section->generateToken();
        $this
            ->sectionManager
            ->save($section);

        return $section->getToken();
    }

    public function generateLogoInserterLinkAction(Section $section)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('http://logoinserter.esnlille.fr/api/%s', $section->getCodeSection()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        return $response;
    }

    public function changeStatus(Section $section)
    {
        return $this
            ->sectionManager
            ->changeStatus($section);
    }
}
