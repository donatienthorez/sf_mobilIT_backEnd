<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryControllerTest extends BaseApiControllerTest
{
    /**
     * @return array
     */
    public function getDataForTestApiMethod()
    {
        return [
            [
                Request::METHOD_GET,
                '/api/android/v1/countries/',
                "MainBundle\\Controller\\AndroidApi\\v1\\CountryController::listAction",
                false,
                Response::HTTP_FORBIDDEN,
                [],
                (object)[
                    "message" => "Invalid token. The token should be the same than the config file."
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/countries/?token=%s', $this->getToken()),
                "MainBundle\\Controller\\AndroidApi\\v1\\CountryController::listAction",
                true,
                Response::HTTP_OK,
                [
                    (object) [
                        "name" => "France",
                        "sections" =>
                        [
                            (object) [
                                "code_section" => "FR-LILL-ESL",
                                "name" => "ESN LILLE"
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }
}
