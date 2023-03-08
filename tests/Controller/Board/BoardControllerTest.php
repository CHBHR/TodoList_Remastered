<?php

namespace App\Tests\Controller\Board;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardControllerTest extends WebTestCase
{
    public function testBoardRedirectsIfNotConnected(): void
    {
        $client = static::createClient();
        $client->request('GET', '/board');
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function testBoardIsUpWhenConnected()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/board');
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }
}
