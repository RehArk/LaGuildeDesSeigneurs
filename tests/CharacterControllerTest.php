<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{

    private $client;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function assertJsonResponse() {
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function assert404Error() {
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');

        $this->assertJsonResponse();
    }

    public function testRedirectIndex() 
    {
        $this->client->request('GET', '/character');

        $response = $this->client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
    
    }
    
    public function testDisplayValide(): void
    {
        $this->client->request('GET', '/character/display/b38657705509f7afe8e5aa114a1357bc54e5b698');

        $this->assertJsonResponse();
    }

    public function testDisplayBadIdentifier() 
    {
        $this->client->request('GET', '/character/display/BadIdentifier');

        $response = $this->client->getResponse();
        $this->assert404Error();
    }

    public function testDisplayNotExistIdentifier() 
    {
        $this->client->request('GET', '/character/display/b38657705509f7afe8e5aa114a1357bc54eerror');

        $response = $this->client->getResponse();
        $this->assert404Error();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse();
    }

}
