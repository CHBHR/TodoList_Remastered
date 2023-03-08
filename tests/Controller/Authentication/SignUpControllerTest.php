<?php

namespace App\Tests\Controller\Authentication;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignUpControllerTest extends WebTestCase
{
    public function testSignupPageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');

        $this->assertSelectorTextContains('h1', 'Inscription');
    }

    //add test to get flash message
    public function testSignupSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');

        $buttonCrawlerNode = $crawler->selectButton("S'inscrire");

        $form = $buttonCrawlerNode->form();

        $form['sign_up[email]']='test@gmail.com';
        $form['sign_up[username]']='UserTestSignup';
        $form['sign_up[password][first]']='test';
        $form['sign_up[password][second]']='test';

        $client->submit($form);

        $this->assertResponseRedirects('/home');
        $client->followRedirect();

        $this->assertSelectorTextNotContains('h1', 'Bonjour');
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }

    //add check to show flash message
    public function testSignupFailure()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');

        $buttonCrawlerNode = $crawler->selectButton("S'inscrire");

        $form = $buttonCrawlerNode->form();

        $form['sign_up[email]']='test@gmail.com';
        $form['sign_up[username]']='UserTestSignup';
        $form['sign_up[password][first]']='test';
        $form['sign_up[password][second]']='test2';

        $client->submit($form);

        $this->assertSelectorTextNotContains('h1', 'Bienvenue sur Todo List');
        $this->assertSelectorTextContains('h1', 'Inscription');
    }
}