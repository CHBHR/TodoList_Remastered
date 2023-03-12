<?php

namespace App\Tests\Controller\Home;

use App\Tests\Controller\AbstractTestController;

class HomeControllerTest extends AbstractTestController
{
    public function testHomepageIsUp(): void
    {
        $this->client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}