<?php

namespace App\Tests\Controller\Task;

use App\Tests\Controller\AbstractTestController;

class CreateTaskControllerTest extends AbstractTestController
{
    public function testCreateTaskRedirectsIfNotConnected()
    {
        $this->client->request('GET', '/tasks/create');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function testCreateTaskPageIsUpWhenConnected()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/tasks/create');
        $this->assertSelectorTextContains('h1', 'Créer une nouvelle tâche');
    }

    //add test to get flash message
    public function testCreateTaskSuccess()
    {
        $this->loginAsUser();

        $datetime = new \DateTime();

        $crawler = $this->client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['task[title]']='titre de test';
        $form['task[content]']='contenu de test';
        $form['task[hasDeadLine]']=false;
        //Does not work
        // $form['task[deadLine][year]']=$datetime->format('Y');
        // $form['task[deadLine][month]']=$datetime->format('m');
        // $form['task[deadLine][day]']=$datetime->format('d');

        // var_dump($test);
        // die();

        $this->client->submit($form);

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche a été bien été ajoutée.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }

    //add check to show flash message
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