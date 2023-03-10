<?php

namespace App\Controller\Admin\Task;

use App\Tests\Controller\AbstractTestController;

class ListOrphanTaskControllerTest extends AbstractTestController
{
    /** 
     * @test 
    */
    public function testRedirectsIfNotAdmin(): void
    {
        $this->client->request('GET', '/admin/task/list');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function testBoardIsUpWhenConnected()
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/task/list');
        $this->assertSelectorTextContains('h1', 'liste des tâches orphelines');
    }
}