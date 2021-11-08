<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{

    private $client;
    private $content;
    private static $identifier;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function assertJsonResponse() 
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function assertIdentifier () 
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }

    public function assert404Error() {
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
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
        $this->client->request('GET', '/character/display/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testDisplayBadIdentifier() 
    {
        $this->client->request('GET', '/character/display/BadIdentifier');

        $this->assert404Error();
    }

    public function testDisplayNotExistIdentifier() 
    {
        $this->client->request('GET', '/character/display/b38657705509f7afe8e5aa114a1357bc54eerror');

        $this->assert404Error();
    }

    public function testModify(): void
    {
        $this->client->request('PUT', '/character/modify/' . self::$identifier);

        $this->assertJsonResponse();
    }

    public function testModifyNotExistIdentifier(): void
    {
        $this->client->request('PUT', '/character/modify/b38657705509f7afe8e5aa114a1357bc54eerror');

        $this->assert404Error();
    }

    public function testDelete(): void
    {
        $this->client->request('PUT', '/character/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }

    public function testDeleteNotExistIdentifier(): void
    {
        $this->client->request('PUT', '/character/delete/b38657705509f7afe8e5aa114a1357bc54eerror');

        $this->assert404Error();
    }

}