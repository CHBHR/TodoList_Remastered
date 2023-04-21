<?php

namespace App\Tests\Controller\Task;

use App\Tests\Controller\AbstractTestController;

class CreateTaskControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testCreateTaskRedirectsIfNotConnected()
    {
        $this->client->request('GET', '/tasks/create');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /**
     * @test
     */
    public function testCreateTaskPageIsUpWhenConnected()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/tasks/create');
        $this->assertSelectorTextContains('h1', 'Créer une nouvelle tâche');
    }

    /**
     * @test
     */
    public function testCreateTaskSuccess()
    {
        $this->loginAsUser();

        //$datetime = new \DateTime();

        $crawler = $this->client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['task[title]']='titre de test';
        $form['task[content]']='contenu de test';
        $form['task[hasDeadLine]']=false;
        
        // Here could go the testing for the deadline

        $this->client->submit($form);

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche a été bien été ajoutée.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }

    /**
     * @test
     */
    public function testCreateTaskFailure()
    {
        $this->loginAsUser();

        $crawler = $this->client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['task[title]']='';
        $form['task[content]']='contenu de test';
        $form['task[hasDeadLine]']=false;
        // $form['task[deaLine]']='';

        //Will create an error
        $crawler = $this->client->submit($form);

        $this->assertSelectorTextContains('h1', 'Symfony Exception');
        $this->assertSelectorTextNotContains('h1', 'Votre tableau Todo List');

    }
}