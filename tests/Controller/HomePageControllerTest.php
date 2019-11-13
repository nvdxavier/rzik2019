<?php


namespace App\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertNotNull($crawler);
    }

}
