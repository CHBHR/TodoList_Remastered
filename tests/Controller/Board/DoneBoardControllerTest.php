<?php

namespace App\Tests\Controller\Board;

use App\Tests\Controller\AbstractTestController;

class DoneBoardControllerTest extends AbstractTestController
{
    /** 
     * @test 
    */
    public function testDoneBoardRedirectsIfNotConnected(): void
    {
        $this->client->request('GET', '/board/done');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function testDoneBoardIsUpWhenConnected()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/board/done');
        $this->assertSelectorTextContains('h1', 'Votre Tâches terminées');
    }
}
