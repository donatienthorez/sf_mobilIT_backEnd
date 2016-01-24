<?php

namespace MainBundle\Creator;

use MainBundle\Entity\Country;

class CountryCreator
{
    public function createCountry($codeCountry, $name, $website, $email)
    {
        $country = new Country();
        $country->setCodeCountry($codeCountry);
        $country->setName($name);
        $country->setWebsite($website);
        $country->setEmail($email);

        return $country;
    }
}
