<?php

namespace MainBundle\Service;

use MainBundle\Manager\CountryManager;
use MainBundle\Manager\ImportCountriesHelper;
use MainBundle\Manager\ImportHelper;

class ImportService
{
    /**
     * @var ImportCountriesHelper
     */
    protected $importHelper;

    /**
     * @var CountryManager
     */
    protected $countryManager;

    /**
     * @param ImportCountriesHelper $importHelper
     * @param CountryManager $countryManager
     */
    public function __construct(
        ImportCountriesHelper $importHelper,
        CountryManager $countryManager
    ) {
        $this->importHelper = $importHelper;
        $this->countryManager = $countryManager;
    }

    public function importCountries()
    {
        $countries = $this->importHelper->importCountries();
        $this->countryManager->saveCountries($countries);
    }

    public function importSections()
    {

    }
}
