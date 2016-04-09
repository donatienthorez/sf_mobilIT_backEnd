<?php

namespace MainBundle\Reader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\DomCrawler\Crawler;
use MainBundle\Creator\CountryCreator;

class ImportCountriesReader
{
    /**
     * @var CountryCreator
     */
    private $countryCreator;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param CountryCreator           $countryCreator
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        CountryCreator $countryCreator,
        EventDispatcherInterface $dispatcher
    ) {
        $this->countryCreator = $countryCreator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return Crawler
     */
    private function filterCountries()
    {
        $html = file_get_contents('https://galaxy.esn.org');
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-1 > div.content > ul > li > a');

        return $elements;
    }

    /**
     * @param $codeCountry
     *
     * @return Crawler
     */
    private function filterCountryDetails($codeCountry)
    {
        $htmlCountry = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/");
        $crawlerCountry = new Crawler($htmlCountry);
        $countriesElement = $crawlerCountry->filter('div.scrinfo');

        return $countriesElement;
    }

    /**
     * @param array $databaseCountries
     *
     * @return array
     */
    public function importCountries(array $databaseCountries, $update = false)
    {
        $countries = [];

        foreach ($this->filterCountries() as $element) {
            $name = $element->nodeValue;
            $codeCountry = explode("/section/", $element->attributes->getNamedItem('href')->value)[1];

            $countryExists = false;

            if (!$update) {
                foreach($databaseCountries as $country) {
                    if ($country->getCodeCountry() === $codeCountry) {
                        $countryExists = true;
                        break;
                    }
                }
            }

            if ($update || (!$update && !$countryExists)) {
                $countriesElement = $this->filterCountryDetails($codeCountry);

                $country = $this->countryCreator->createCountry(
                    $codeCountry,
                    $name,
                    $countriesElement->first()->text(),
                    $countriesElement->last()->text()
                );

                $this->dispatcher->dispatch(
                    'display.message',
                    new GenericEvent(
                        sprintf("Updating country : %s ...", $country->getName())
                    )
                );

                $countries[] = $country;
            }
        }

        return $countries;
    }
}
