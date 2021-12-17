<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day14ControllerTest extends WebTestCase
{
    public function testDay14Part1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day14/1/day14test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(1588, $content);
    }

    public function testDay14Part2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day14/2/day14test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(2188189693529, $content);
    }
}