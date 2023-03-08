<?php

namespace App\Tests\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageIsUp(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}