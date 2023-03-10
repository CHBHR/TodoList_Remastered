<?php

namespace App\Tests\Controller\Board;

use App\Tests\Controller\AbstractTestController;

class BoardControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testBoardRedirectsIfNotConnected(): void
    {
        $this->client->request('GET', '/board');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function testBoardIsUpWhenConnected()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/board');
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }
}
