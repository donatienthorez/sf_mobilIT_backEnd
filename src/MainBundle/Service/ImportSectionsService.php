<?php

namespace MainBundle\Service;

use MainBundle\Fetcher\CountryFetcher;
use MainBundle\Manager\CountryManager;
use MainBundle\Manager\SectionManager;
use MainBundle\Reader\ImportSectionsReader;

class ImportSectionsService
{
    /**
     * @var ImportSectionsReader
     */
    protected $importSectionsReader;

    /**
     * @var CountryManager
     */
    protected $countryManager;

    /**
     * @var SectionManager
     */
    protected $sectionManager;

    /**
     * @var CountryFetcher
     */
    protected $countryFetcher;

    public function __construct($importSectionsReader, $countryManager, $countryFetcher, $sectionManager)
    {
        $this->importSectionsReader = $importSectionsReader;
        $this->countryManager = $countryManager;
        $this->countryFetcher = $countryFetcher;
        $this->sectionManager = $sectionManager;
    }

    public function importSections()
    {
        $countries = $this->countryFetcher->getCountries();
        $sections = $this->importSectionsReader->importSections($countries);
        $this->sectionManager->saveSections($sections);
    }
}
