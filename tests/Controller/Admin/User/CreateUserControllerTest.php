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

        // test to see if it works eventually
        // $form['user[roles][0]']->untick();
        // $form['user[roles][1]']->select(true);

        //print_r($form['user[roles]']);
        // var_dump($form['user[roles][1]']->tick());
        // die();
        // $form['user[roles]']=true;

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/users/list');
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

        $this->assertStringContainsString("L'utilisateur a bien été ajouté.", $crawler->text());
    }
}
