<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionControllerTest extends BaseApiControllerTest
{
    /**
     * @return array
     */
    public function getDataForTestApiMethod()
    {
        return [
            [
                Request::METHOD_GET,
                '/api/android/v1/sections/',
                'MainBundle\\Controller\\AndroidApi\\v1\\SectionController::listAction',
                false,
                Response::HTTP_FORBIDDEN
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/sections/?token=%s', $this->getToken()),
                'MainBundle\\Controller\\AndroidApi\\v1\\SectionController::listAction',
                true,
                Response::HTTP_OK,
                [],
                [
                    (object) [
                        "code_section" => "FR-LILL-ESL",
                        "name" => "ESN LILLE",
                        "website" => "website",
                        "university" => "Lill univ",
                        "phone" => "00000000",
                         "email" => "email-fr-lill@esn.com",
                        "logo_url" => "www.urllogo.com",
                    ]
                ]
            ],
            [
                Request::METHOD_GET,
                '/api/android/v1/sections/FR-LILL-ESL',
                'MainBundle\\Controller\\AndroidApi\\v1\\SectionController::getAction',
                false,
                Response::HTTP_FORBIDDEN
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/sections/FR-LILL-ESL?token=%s', $this->getToken()),
                'MainBundle\\Controller\\AndroidApi\\v1\\SectionController::getAction',
                true,
                Response::HTTP_OK,
                [],
                (object) [
                    "code_section" => "FR-LILL-ESL",
                    "name" => "ESN LILLE",
                    "website" => "website",
                    "university" => "Lill univ",
                    "phone" => "00000000",
                    "email" => "email-fr-lill@esn.com",
                    "logo_url" => "www.urllogo.com",
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/sections/TL-SECT-IN?token=%s', $this->getToken()),
                'MainBundle\\Controller\\AndroidApi\\v1\\SectionController::getAction',
                false,
                Response::HTTP_NOT_FOUND
            ]
        ];
    }
}
