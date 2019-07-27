<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerPlaylistProjectTest extends WebTestCase
{
    public function testCreateNewProjectRoot()
    {
        $client = static::createClient();

        $client->request('GET', '/artist/new/project');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}