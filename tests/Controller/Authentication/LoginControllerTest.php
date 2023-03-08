<?php

namespace App\Tests\Controller\Authentication;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllertest extends WebTestCase
{
    public function testLoginWithValidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Connexion');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['_username'] = 'TestUser2';
        $form['_password'] = 'test';

        $this->assertResponseIsSuccessful();

    }

    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Connexion');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['_username'] = 'WrongUserName';
        $form['_password'] = 'test';

        $this->assertSelectorTextContains('h1', 'Connexion');
        $this->assertSelectorTextNotContains('h1', 'Bonjour');
    }

    public function testHomepageWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Bonjour TestUser2');
    }

    public function testLogout()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Bonjour TestUser2');

        $client->request('GET', '/logout');
        $this->assertSelectorNotExists('h4', 'Bonjour TestUser2');
    }
}