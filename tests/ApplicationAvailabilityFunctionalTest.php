<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/login'),
            array('/forgottenPassword'),
            array('/user/register'),
            array('/home'),
        );
    }

    public function testBlogArchives()
    {
        $client = self::createClient();
        $url = $client->getContainer()->get('router')->generate('playlist_project');
        $client->request('GET', $url);
    }


}