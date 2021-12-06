<?php


namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day6ControllerTest extends WebTestCase
{
    public function testPart1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day6/1/day6test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(5934, $content);
    }

    public function testPart2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day6/2/day6test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(26984457539,$content);
    }
}