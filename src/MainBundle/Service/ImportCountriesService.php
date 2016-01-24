<?php

namespace MainBundle\Service;

use MainBundle\Manager\CountryManager;
use MainBundle\Reader\ImportCountriesReader;

class ImportCountriesService
{
    /**
     * @var ImportCountriesReader
     */
    protected $importCountriesReader;

    /**
     * @var CountryManager
     */
    protected $countryManager;

    public function __construct($importCountriesReader, $countryManager)
    {
        $this->importCountriesReader = $importCountriesReader;
        $this->countryManager = $countryManager;
    }

    public function importCountries()
    {
        $countries = $this->importCountriesReader->importCountries();
        $this->countryManager->saveCountries($countries);
    }
}
