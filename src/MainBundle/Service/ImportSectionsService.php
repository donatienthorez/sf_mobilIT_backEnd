<?php

namespace MainBundle\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
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

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(
        ImportSectionsReader $importSectionsReader,
        CountryManager $countryManager,
        CountryFetcher $countryFetcher,
        SectionManager $sectionManager,
        EventDispatcherInterface $dispatcher)
    {
        $this->importSectionsReader = $importSectionsReader;
        $this->countryManager = $countryManager;
        $this->countryFetcher = $countryFetcher;
        $this->sectionManager = $sectionManager;
        $this->dispatcher = $dispatcher;
    }

    public function importSections($codeCountry = null)
    {
        $this->dispatcher->dispatch(
            'display.message',
            new GenericEvent("Getting the countries from database ...")
        );

        if ($codeCountry) {
            $countries = $this->countryFetcher->getCountry($codeCountry);
        } else {
            $countries = $this->countryFetcher->getCountries();
        }

        foreach ($countries as $country) {
            $this->dispatcher->dispatch(
                'display.message',
                new GenericEvent(sprintf("Getting the sections of %s ...", $country->getName()))
            );
            $sections = $this->importSectionsReader->importSections($country);
            $this->dispatcher->dispatch(
                'display.message',
                new GenericEvent(sprintf("Saving the sections of %s in database (%s) ...", $country->getName(), count($sections)))
            );
            $this->sectionManager->saveSections($sections);
        }

    }
}
