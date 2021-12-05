<?php


namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day4ControllerTest extends WebTestCase
{
    public function testPart1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day4/1/day4test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(4512, $content);
    }

    public function testPart2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day4/2/day4test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(1924,$content);
    }
}