<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegIdControllerTest extends BaseApiControllerTest
{
    /**
     * @return array
     */
    public function getDataForTestApiMethod()
    {
        return [
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                false,
                Response::HTTP_BAD_REQUEST,
                [
                    'regId' => "testRegid01",
                    'section' => "TL-SECT-01"
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                false,
                Response::HTTP_FORBIDDEN,
                [
                    'token' => "aaaaaa",
                    'regId' => "testRegid01",
                    'section' => "TL-SECT-01"
                ],
                (object)[
                    "message" => "Invalid token. The token should be the same than the config file."
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                false,
                Response::HTTP_BAD_REQUEST,
                [
                    'token' => $this->getToken(),
                    'section' => "TL-SECT-01"
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                false,
                Response::HTTP_FORBIDDEN,
                [
                    'token' => $this->getToken(),
                    'regId' => "testRegid01",
                    'section' => "TL-SECT-IN"
                ],
                (object)[
                    "message" => "The section doesn't exist."
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                false,
                Response::HTTP_BAD_REQUEST,
                [
                    'token' => $this->getToken(),
                    'regId' => "testRegid01",
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                true,
                Response::HTTP_OK,
                [
                    'token' => $this->getToken(),
                    'regId' => "testRegid01",
                    'section' => "TL-SECT-01"
                ],
                (object)[
                    'id' => 'testRegid01',
                    'section' => (object) [
                        "code_section" => "TL-SECT-01",
                        "name" => "Section1",
                        "country" => (object) [
                            "code_country" => "TL",
                            "name" => "TEST LAND"
                        ]
                    ]
                ]
            ],
            [
                Request::METHOD_POST,
                '/api/android/v1/regids/',
                'MainBundle\\Controller\\AndroidApi\\v1\\RegIdController::createAction',
                true,
                Response::HTTP_OK,
                [
                    'token' => $this->getToken(),
                    'regId' => "testRegid02",
                    'section' => "TL-SECT-01"
                ],
                (object)[
                    'id' => 'testRegid02',
                    'section' => (object) [
                        "code_section" => "TL-SECT-01",
                        "name" => "Section1",
                        "country" => (object) [
                            "code_country" => "TL",
                            "name" => "TEST LAND"
                        ]
                    ]
                ]
            ],

        ];
    }
}
