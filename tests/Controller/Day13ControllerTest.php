<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class Day13ControllerTest extends WebTestCase
{
    public function testDay13Part1()
    {
        $client = $this->makeClient();
        $client->request('GET', '/day13/1/day13test');
        $this->assertStatusCode(200, $client);
        $content = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(17, $content);
    }
}