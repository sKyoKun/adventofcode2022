<?php


namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day5ControllerTest extends WebTestCase
{
    public function testPart1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day5/1/day5test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(5, $content);
    }

    public function testPart2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day5/2/day5test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(12,$content);
    }
}