<?php

namespace MainBundle\Reader;

use MainBundle\Fetcher\SectionFetcher;
use Symfony\Component\DomCrawler\Crawler;
use MainBundle\Creator\SectionCreator;
use MainBundle\Entity\Country;

class ImportSectionsReader
{
    /**
     * @var SectionCreator
     */
    private $sectionCreator;

    /**
     * @var SectionFetcher
     */
    private $sectionFetcher;

    /**
     * @param SectionCreator                     $sectionCreator
     * @param \MainBundle\Fetcher\SectionFetcher $sectionFetcher
     */
    public function __construct(
      SectionCreator $sectionCreator,
      SectionFetcher $sectionFetcher
    ) {
        $this->sectionCreator = $sectionCreator;
        $this->sectionFetcher = $sectionFetcher;
    }

    /**
     * @param $country
     *
     * @return Crawler
     */
    private function filterSections($country)
    {
        $html = $this->getDataFromUrl(
            sprintf('https://galaxy.esn.org/section/%s', $country)
        );
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-0 > div.content > ul > li > a');

        return $elements;
    }

    function getDataFromUrl($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @param $codeCountry
     * @param $codeSection
     * @param bool $details
     *
     * @return Crawler
     */
    private function filterSectionDetails($codeCountry, $codeSection, $details = false)
    {
        $htmlSection = $this->getDataFromUrl(
            sprintf('https://galaxy.esn.org/section/%s/%s', $codeCountry, $codeSection)
        );

        $crawlerSection = new Crawler($htmlSection);
        $filter = $details ? '#block-esn_galaxy_ldap-2 > div.content > div > div.scinfo' :
            '#block-esn_galaxy_ldap-2 > div.content > div > div.scrinfo';

        $sectionsElement = $crawlerSection->filter($filter);

        return $sectionsElement;
    }

    private function parseAddress($address)
    {
        $address = str_replace("<br>", " ", $address);
        $address = str_replace("<div class=\"scrinfo\">", " ", $address);
        $address = str_replace("</div>", " ", $address);

        return $address;
    }

    /**
     * @param Country $country
     *
     * @return array
     */
    public function importSections(Country $country)
    {
        $sections = array();
        $codeCountry = $country->getCodeCountry();

        foreach ($this->filterSections($codeCountry) as $element) {

            $name = $element->nodeValue;
            $sectionCode = substr(explode(
                sprintf("/section/%s/", $codeCountry),
                $element->attributes->getNamedItem('href')->value
            )[1], 0, 11);

            $section = $this->sectionFetcher->getSection($sectionCode);

            if (!$section || ($section && $section->isGalaxyImport())
            ) {
                $sectionElementsField = $this
                    ->filterSectionDetails(
                        $codeCountry,
                        $sectionCode,
                        true
                    );

                $sectionElementsIterator = $this
                    ->filterSectionDetails(
                        $codeCountry,
                        $sectionCode
                    )
                    ->getIterator();
                $information = [];
                $keys = ["Address: ","Telephone:","Section website: ", "E-Mail: ","University name: "];
                $cpt = 0;
                foreach ($sectionElementsField as $sectionElement) {
                    foreach ($keys as $key) {
                        switch ($sectionElement->nodeValue) {
                            case $keys[0]:
                                $information[$cpt] = $this->parseAddress($sectionElementsIterator
                                    ->current()
                                    ->ownerDocument
                                    ->saveHTML(
                                        $sectionElementsIterator->current()
                                    ));
                                break;
                            default:
                                $information[$cpt] = $sectionElementsIterator
                                    ->current()
                                    ->nodeValue;
                        }
                    }
                    $cpt++;
                    $sectionElementsIterator->next();
                }
                $section = $this->sectionCreator->createSection($sectionCode, $name, $information, $country);
                $sections[] = $section;
            }
        }

        return $sections;
    }
}
