<?php

namespace App\Tests\Controller\Task;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateTaskControllerTest extends WebTestCase
{
    public function testCreateTaskRedirectsIfNotConnected()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/create');
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function testCreateTaskPageIsUpWhenConnected()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/create');
        $this->assertSelectorTextContains('h1', 'Créer une nouvelle tâche');
    }

    //add test to get flash message
    public function testCreateTaskSuccess()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['task[title]']='titre de test';
        $form['task[content]']='contenu de test';
        $form['task[hasDeadLine]']=false;
        // $form['task[deaLine]']='';

        $client->submit($form);

        $this->assertResponseRedirects('/board');
        $crawler = $client->followRedirect();

        $this->assertStringContainsString("La tâche a été bien été ajoutée.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }

    //add check to show flash message
    public function testCreateTaskFailure()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');

        $buttonCrawlerNode = $crawler->selectButton("Ajouter");

        $form = $buttonCrawlerNode->form();

        $form['task[title]']='';
        $form['task[content]']='contenu de test';
        $form['task[hasDeadLine]']=false;
        // $form['task[deaLine]']='';

        //Will create an error
        $crawler = $client->submit($form);

        $this->assertSelectorTextContains('h1', 'Symfony Exception');
        $this->assertSelectorTextNotContains('h1', 'Votre tableau Todo List');

    }
}