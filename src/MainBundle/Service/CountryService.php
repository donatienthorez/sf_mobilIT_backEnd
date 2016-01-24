<?php

namespace MainBundle\Service;

use MainBundle\Fetcher\CountryFetcher;

class CountryService
{
    /**
     * @var CountryFetcher
     */
    private $countryFetcher;

    /**
     * @param CountryFetcher $countryFetcher
     */
    public function __construct(
        CountryFetcher $countryFetcher
    ) {
        $this->countryFetcher = $countryFetcher;
    }

    public function getCountries()
    {
        $data = $this
            ->countryFetcher
            ->getCountries();

        return $data;
    }
}
