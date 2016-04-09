<?php

namespace MainBundle\Reader;

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
        $html = file_get_contents(sprintf('https://galaxy.esn.org/section/%s', $country),
            false,
            stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "allow_self_signed" => false
                    ]
                ]
            )
        );
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-0 > div.content > ul > li > a');

        return $elements;
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
        $htmlSection = file_get_contents(
            sprintf('https://galaxy.esn.org/section/%s/%s', $codeCountry, $codeSection),
            false,
            stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "allow_self_signed" => false
                    ]
                ]
            )
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

        foreach ($this->filterSections($country->getCodeCountry()) as $element) {

            $name = $element->nodeValue;
            $codeSection = explode(
                sprintf("/section/%s/", $country->getCodeCountry()),
                $element->attributes->getNamedItem('href')->value
            )[1];

            if ($country->getSection($codeSection) && $country->getSection($codeSection)->isGalaxyImport()) {
                $sectionElementsField = $this
                    ->filterSectionDetails(
                        $country->getCodeCountry(),
                        $codeSection,
                        true
                    );

                $sectionElementsIterator = $this
                    ->filterSectionDetails(
                        $country->getCodeCountry(),
                        $codeSection
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
                $section = $this->sectionCreator->createSection($codeSection, $name, $information, $country);
                $sections[] = $section;
            }
        }

        return $sections;
    }
}
