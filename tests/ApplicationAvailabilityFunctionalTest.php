<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{

    /**
     * assert that url rendering a page and some datas or visuals contents for user then assert true
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * assert that url provider only doo a job then assert false for rendering page element
     * @param $url
     * @dataProvider urlFalsePRovider
     */
    public function testUrlRedirect($urlFalsePRovider)
    {
        $client = self::createClient();
        $client->request('GET', $urlFalsePRovider);
        $this->assertFalse($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/login'),
            array('/forgottenPassword'),
            array('/home'),
            array('/register'),
            array('/create/article'),
            array('/playlist'),
            array('/playlist/project'),
        );
    }

    public function urlFalsePRovider()
    {
        return array(
            array('/logout'),
            array('/artistband/profile/9'),
            array('/settings/profile/'),
            array('/music/acquisition'),
            array('/artist/new/project'),
            array('/music/file'),
            array('/edit_playlist'),
        );
    }

}
