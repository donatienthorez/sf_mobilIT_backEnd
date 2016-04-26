<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseController extends WebTestCase
{
    protected $client;

    private $token = "g6g2A52mGPPbKaaHmFjz";

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function getToken()
    {
        return $this->token;
    }
}
