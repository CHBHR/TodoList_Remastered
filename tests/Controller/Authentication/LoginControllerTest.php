<?php

namespace App\Tests\Controller\Authentication;

use App\Tests\Controller\AbstractTestController;

class LoginControllertest extends AbstractTestController
{
    public function testLoginWithValidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

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
        $crawler = $this->client->request('GET', '/login');

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
        $this->loginAsUser();

        $this->client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Bonjour TestUser2');
    }

    public function testLogout()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Bonjour TestUser2');

        $this->client->request('GET', '/logout');
        $this->assertSelectorNotExists('h4', 'Bonjour TestUser2');
    }
}