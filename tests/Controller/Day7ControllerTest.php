<?php


namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day7ControllerTest extends WebTestCase
{
    public function testPart1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day7/1/day7test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(37, $content);
    }

    public function testPart2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day7/2/day7test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(168,$content);
    }
}