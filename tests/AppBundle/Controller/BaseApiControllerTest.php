<?php

namespace Tests\AppBundle\Controller;

abstract class BaseApiControllerTest extends BaseController
{
    /**
     * @dataProvider getDataForTestApiMethod
     *
     * @param string $requestMethod
     * @param string $requestUrl
     * @param string $controller
     * @param bool $isResponseSuccessful
     * @param int $responseStatusCode
     * @param array $params
     * @param mixed $expectedResponse
     */
    public function testApiMethod(
        $requestMethod,
        $requestUrl,
        $controller,
        $isResponseSuccessful,
        $responseStatusCode,
        array $params = [],
        $expectedResponse = null
    ) {
        $this->client->request($requestMethod, $requestUrl, $params);
        $response = $this->client->getResponse();

        $this->assertEquals($controller, $this->client->getRequest()->attributes->get('_controller'));
        $this->assertEquals($isResponseSuccessful, $response->isSuccessful());
        $this->assertEquals($responseStatusCode, $response->getStatusCode());

        $response = json_decode($this->client->getResponse()->getContent());

        if ($expectedResponse) {
            $this->assertEquals($response, $expectedResponse);
        }
    }

    /**
     * @return array
     */
    abstract public function getDataForTestApiMethod();
}
