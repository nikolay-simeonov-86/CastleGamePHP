<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProviderNoLogin
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlProviderWithLogin
     */
    public function testPageIsSuccessfulAndRedirected($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertFalse($client->getResponse()->isSuccessful());
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function urlProviderNoLogin()
    {
        return array(
            array('/'),
            array('/map'),
            // ...
        );
    }

    public function urlProviderWithLogin()
    {
        return array(
            array('/army'),
            array('/battles'),
            array('/castles'),
            array('/messages/inbox'),
            array('/user/{id}'),
            // ...
        );
    }
}