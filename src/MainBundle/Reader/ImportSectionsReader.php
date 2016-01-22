<?php

namespace MainBundle\Reader;

use MainBundle\Creator\SectionCreator;
use Symfony\Component\DomCrawler\Crawler;

class ImportSectionsReader
{
    /**
     * @var SectionCreator
     */
    private $sectionCreator;

    /**
     * @param SectionCreator $sectionCreator
     */
    public function __construct(SectionCreator $sectionCreator)
    {
        $this->sectionCreator = $sectionCreator;
    }

    /**
     * @param $country
     *
     * @return Crawler
     */
    private function filterSections($country)
    {
        $html = file_get_contents('https://galaxy.esn.org/section/' . $country);
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-0 > div.content > ul > li > a');

        return $elements;
    }

    /**
     * @param $codeCountry
     * @param $codeSection
     *
     * @return Crawler
     */
    private function filterSectionDetails($codeCountry, $codeSection)
    {
        $htmlSection = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/" . $codeSection);
        $crawlerSection = new Crawler($htmlSection);
        $sectionsElement = $crawlerSection->filter('#block-esn_galaxy_ldap-2 > div.content > div > div.scrinfo');

        return $sectionsElement;
    }

    /**
     * @param $codeCountry
     * @param $codeSection
     *
     * @return Crawler
     */
    private function filterSectionDetailsFields($codeCountry, $codeSection)
    {
        $htmlSection = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/" . $codeSection);
        $crawlerSection = new Crawler($htmlSection);
        $sectionsElement = $crawlerSection->filter('#block-esn_galaxy_ldap-2 > div.content > div > div.scinfo');

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
     * @param $countries
     *
     * @return array
     */
    public function importSections($countries)
    {
        $sections = array();

        foreach ($countries as $country) {
            foreach ($this->filterSections($country->getCodeCountry()) as $element) {

                $name = $element->nodeValue;
                $codeSection = explode(
                    "/section/" . $country->getCodeCountry() . '/',
                    $element->attributes['href']->value
                )[1];

                $sectionElementsField = $this
                    ->filterSectionDetailsFields(
                        $country->getCodeCountry(),
                        $codeSection
                    );

                $sectionElementsIterator = $this
                    ->filterSectionDetails(
                        $country->getCodeCountry(),
                        $codeSection
                    )
                    ->getIterator();
                $informations = array();
                $keys = array("Address: ","Telephone:","Section website: ", "E-Mail: ","University name: ");
                $cpt = 0;
                foreach ($sectionElementsField as $sectionElement) {
                    foreach ($keys as $key) {

                        switch ($sectionElement->nodeValue) {
                            case $keys[0]:
                                $informations[$cpt] = $this->parseAddress($sectionElementsIterator
                                    ->current()
                                    ->ownerDocument
                                    ->saveHTML(
                                        $sectionElementsIterator->current()
                                    ));
                                break;
                            default:
                                $informations[$cpt] = $sectionElementsIterator
                                    ->current()
                                    ->nodeValue;
                        }
                    }
                    $cpt++;
                    $sectionElementsIterator->next();
                }
                $section = $this->sectionCreator->createSection($codeSection, $name, $informations, $country);
                $sections[] = $section;
            }
        }

        return $sections;
    }
}
