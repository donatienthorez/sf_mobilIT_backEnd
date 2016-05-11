<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuideControllerTest extends BaseApiControllerTest
{
    /**
     * @return array
     */
    public function getDataForTestApiMethod()
    {
        return [
            [
                Request::METHOD_GET,
                '/api/android/v1/guides/FR-LILL-ESL',
                'MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction',
                false,
                Response::HTTP_FORBIDDEN
            ],
            [
                Request::METHOD_GET,
                '/api/android/v1/guides/FR-LILL-ESL?token=aaaaaaa',
                'MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction',
                false,
                Response::HTTP_FORBIDDEN,
                [],
                (object)[
                    "message" => "Invalid token. The token should be the same than the config file."
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/guides/FR-LILL-ESL?token=%s', $this->getToken()),
                "MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction",
                true,
                Response::HTTP_OK,
                [],
                (object) [
                    'code_section' => 'FR-LILL-ESL',
                    'activated' => true,
                    'created' => true,
                    'nodes' => [
                        (object) [
                            'id' => 1,
                            'title' => 'First Category',
                            'content' => 'First Category content',
                            'nodes' => [],
                            'position' => 0
                        ],
                        (object) [
                            'id' => 2,
                            'title' => 'Second Category',
                            'content' => 'Second Category content',
                            'nodes' => [],
                            'position' => 1
                        ]
                    ]
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/guides/TL-SECT-01?token=%s', $this->getToken()),
                "MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction",
                true,
                Response::HTTP_OK,
                [],
                (object) [
                    'code_section' => 'TL-SECT-01',
                    'activated' => false,
                    'created' => true
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/guides/TL-SECT-02?token=%s', $this->getToken()),
                "MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction",
                true,
                Response::HTTP_OK,
                [],
                (object) [
                    'created' => false
                ]
            ],
            [
                Request::METHOD_GET,
                sprintf('/api/android/v1/guides/TL-SECT-IN?token=%s', $this->getToken()),
                "MainBundle\\Controller\\AndroidApi\\v1\\GuideController::getAction",
                false,
                Response::HTTP_NOT_FOUND,
            ],
        ];
    }
}
