<?php

namespace MainBundle\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use MainBundle\Manager\CountryManager;
use MainBundle\Fetcher\CountryFetcher;
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

    /**
     * @param ImportCountriesReader    $importCountriesReader
     * @param CountryManager           $countryManager
     * @param CountryFetcher           $countryFetcher
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        ImportCountriesReader $importCountriesReader,
        CountryManager $countryManager,
        CountryFetcher $countryFetcher,
        EventDispatcherInterface $dispatcher
    ) {
        $this->importCountriesReader = $importCountriesReader;
        $this->countryManager = $countryManager;
        $this->countryFetcher = $countryFetcher;
        $this->dispatcher = $dispatcher;
    }

    public function importCountries($update = false)
    {
        $this->dispatcher->dispatch(
            'display.message',
            new GenericEvent("Getting the countries from database ...")
        );
        $databaseCountries = $this->countryFetcher->getCountries();

        $countries = $this->importCountriesReader->importCountries($databaseCountries, $update);


        $this->dispatcher->dispatch(
            'display.message',
            new GenericEvent(
                sprintf("Saving countries in database")
            )
        );

        $this->countryManager->saveCountries($countries);
    }
}
