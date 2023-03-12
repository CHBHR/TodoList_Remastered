<?php

namespace App\Tests\Controller\Authentication;

use App\Tests\Controller\AbstractTestController;

class SignUpControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testSignupPageIsUp()
    {
        $this->client->request('GET', '/signup');

        $this->assertSelectorTextContains('h1', 'Inscription');
    }

    /**
     * @test
     */
    public function testSignupSuccess()
    {
        $crawler = $this->client->request('GET', '/signup');

        $buttonCrawlerNode = $crawler->selectButton("S'inscrire");

        $form = $buttonCrawlerNode->form();

        $form['sign_up[email]']='test@gmail.com';
        $form['sign_up[username]']='UserTestSignup';
        $form['sign_up[password][first]']='test';
        $form['sign_up[password][second]']='test';

        $this->client->submit($form);

        $this->assertResponseRedirects('/home');
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextNotContains('h1', 'Bonjour');
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
        $this->assertStringContainsString("Vous êtes bien inscrit.", $crawler->text());
    }

    /**
     * @test
     */
    public function testSignupFailure()
    {
        $crawler = $this->client->request('GET', '/signup');

        $buttonCrawlerNode = $crawler->selectButton("S'inscrire");

        $form = $buttonCrawlerNode->form();

        $form['sign_up[email]']='test@gmail.com';
        $form['sign_up[username]']='UserTestSignup';
        $form['sign_up[password][first]']='test';
        $form['sign_up[password][second]']='test2';

        $this->client->submit($form);

        $this->assertSelectorTextNotContains('h1', 'Bienvenue sur Todo List');
        $this->assertSelectorTextContains('h1', 'Inscription');
    }
}