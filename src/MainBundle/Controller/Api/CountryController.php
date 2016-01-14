<?php

namespace MainBundle\Controller\Api;

use MainBundle\Entity\Country;
use MainBundle\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @FosRest\Prefix("countries")
 * @FosRest\NamePrefix("api_countries_")
 */
class CountryController extends Controller
{
    public function importAction()
    {
        $html = file_get_contents('https://galaxy.esn.org');
        $crawler = new Crawler($html);
        $elements = $crawler->filter('#block-esn_galaxy_ldap-1 > div.content > ul > li > a');
        $em = $this->getDoctrine()->getEntityManager();

        foreach ($elements as $element) {
            $name = $element->nodeValue;
            $codeCountry = explode("/section/", $element->attributes['href']->value)[1];
            $country = new Country();
            $country->setCodeCountry($codeCountry);
            $country->setName($name);

            $htmlCountry = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/");
            $crawlerCountry = new Crawler($htmlCountry);
            $countriesElement = $crawlerCountry->filter('div.scrinfo');
            $country->setWebsite($countriesElement->first()->text());
            $country->setEmail($countriesElement->last()->text());

            $em->persist($country);

            $sections = $crawlerCountry->filter('#block-esn_galaxy_ldap-0 div.content ul li a');
            foreach ($sections as $section) {
                $name = $section->nodeValue;
                $codeSection = explode("/" . $codeCountry ."/", $section->attributes['href']->value)[1];
                $sectionEntity = new Section();
                $sectionEntity->setCodeSection($codeSection);
                $sectionEntity->setCountry($country);
                $sectionEntity->setName($name);

                $em->persist($sectionEntity);

//                $htmlCountry = file_get_contents('https://galaxy.esn.org/section/' . $codeCountry . "/");
//                $crawlerCountry = new Crawler($htmlCountry);
//                $countriesElement = $crawlerCountry->filter('div.scrinfo');
//                $country->setWebsite($countriesElement->first()->text());
//                $country->setEmail($countriesElement->last()->text());
//
//                $sections = $crawlerCountry->filter('#block-esn_galaxy_ldap-0 div.content ul li a');
//                foreach($sections as $section) {
//                    $name = $element->nodeValue;
//                    $codeSection = explode("/" . $codeCountry ."/", $section->attributes['href']->value)[1];
//                    $section = new Section();
//                    $section->setCodeSection($codeSection);
//                    $section->setCountry($country);
//                    $section->setName($name);
//                }
            }
        }
        $em->flush();
        var_dump("done");
        die;
    }
}
