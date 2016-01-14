<?php

namespace MainBundle\Manager;

use MainBundle\Creator\CountryCreator;
use Symfony\Component\DomCrawler\Crawler;

class ImportCountriesHelper
{
    /**
     * @var CountryCreator
     */
    private $countryCreator;

    /**
     * @param CountryCreator $countryCreator
     */
    public function __construct(CountryCreator $countryCreator)
    {
        $this->countryCreator = $countryCreator;
    }

    private function filterCountries()
    {
        $html = file_get_contents('https://galaxy.esn.org');
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-1 > div.content > ul > li > a');

        return $elements;
    }

    private function filterCountryDetails($codeCountry)
    {
        $htmlCountry = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/");
        $crawlerCountry = new Crawler($htmlCountry);
        $countriesElement = $crawlerCountry->filter('div.scrinfo');

        return $countriesElement;
    }

    public function importCountries()
    {
        $countries = array();

        foreach ($this->filterCountries() as $element) {
            $name = $element->nodeValue;
            $codeCountry = explode("/section/", $element->attributes['href']->value)[1];
            $countriesElement = $this->filterCountryDetails($codeCountry);

            $country = $this->countryCreator->createCountry(
                $codeCountry,
                $name,
                $countriesElement->first()->text(),
                $countriesElement->last()->text()
            );

            $countries[] = $country;
        }

        return $countries;
    }
}
