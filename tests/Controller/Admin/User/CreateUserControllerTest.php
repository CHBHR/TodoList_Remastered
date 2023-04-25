<?php

namespace App\Controller\Admin\User;

use App\Tests\Controller\AbstractTestController;

class CreateUserControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testCreateUserRedirectsIfNotConnected()
    {
        $this->client->request('GET', '/admin/users/create');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /**
     * @test
     */
    public function testCreateUserAsAdmin()
    {
        $this->loginAsAdmin();

        $crawler = $this->client->request('GET', '/admin/users/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['user[username]']='TestCreatedUser';
        $form['user[email]']='testcreateduser@gmail.com';
        $form['user[password][first]']='test';
        $form['user[password][second]']='test';

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/users/list');
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

        $this->assertStringContainsString("L'utilisateur a bien été ajouté.", $crawler->text());
    }
}
