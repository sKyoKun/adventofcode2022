<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day9ControllerTest extends WebTestCase
{
    public function testDay9Part1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day9/1/day9test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(15, $content);
    }

    public function testDay9Part2()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day9/2/day9test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(1134, $content);
    }
}