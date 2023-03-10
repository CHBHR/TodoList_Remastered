<?php

namespace App\Tests\Controller\Admin;

use App\Tests\Controller\AbstractTestController;

class AdminBoardControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testBoardRedirectsIfNotConnected(): void
    {
        $this->client->request('GET', '/admin/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function testAdminDashboardIsUpWhenConnected()
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/dashboard');
        $this->assertSelectorTextContains('h1', 'Tableau de bord Administrateur');
    }
}
