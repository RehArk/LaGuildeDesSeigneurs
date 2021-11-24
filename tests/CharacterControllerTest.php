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
        $this->client->request(
            'POST', 
            '/character/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "kind":"Dame",
                "name":"Eldalótë",
                "surname":"Fleur elfique",
                "caste":"Elfe",
                "knowledge":"Arts",
                "intelligence":120,
                "life":12,
                "image":"/images/eldalote.jpg"
            }'
        );

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

        $this->client->request(
            'PUT', 
            '/character/modify/' . self::$identifier,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name":"Eldalótë modify",
                "intelligence":125,
                "life":13
            }'
        );

        $this->assertJsonResponse();
    }

    public function testModifyNotExistIdentifier(): void
    {
        $this->client->request('PUT', '/character/modify/b38657705509f7afe8e5aa114a1357bc54eerror');

        $this->assert404Error();
    }

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/character/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }

    public function testDeleteNotExistIdentifier(): void
    {
        $this->client->request('DELETE', '/character/delete/b38657705509f7afe8e5aa114a1357bc54eerror');

        $this->assert404Error();
    }

    public function testImages()
    {
        $this->client->request('GET', '/character/image/dames/2');
        $this->assertJsonResponse();

        $this->client->request('GET', '/character/image/2');
        $this->assertJsonResponse();
    }

     public function testIndexWithIntelligence(): void
     {
         $this->client->request('GET', '/character/index/intelligence/120');

         $this->assertJsonResponse();
     }

     public function testIndexWithIntelligence404(): void
     {
         $this->client->request('GET', '/character/index/intelligence/120a');

         $this->assert404Error();
     }

     public function testHtmlIndexWithIntelligence(): void
     {
         $this->client->request('GET', '/character/html/intelligence/120');

         $response = $this->client->getResponse();
         $this->assertEquals(200, $response->getStatusCode());
     }

     public function testHtmlIndexWithIntelligence404(): void
     {
         $this->client->request('GET', '/character/html/intelligence/120a');

         $this->assert404Error();
     }

     // /!\ --- 
     // si les tests sont executer, il charge à l'infini à cause d'un probleme de curl
     // /!\ --- 

     // public function testApiIndexWithIntelligence(): void
     // {
     //     $this->client->request('GET', '/character/api-html/intelligence/120');

     //     $this->assertJsonResponse();
     // }

     // public function testApiIndexWithIntelligence404(): void
     // {
     //     $this->client->request('GET', '/character/api-html/intelligence/120a');

     //     $this->assert404Error();
     // }

}