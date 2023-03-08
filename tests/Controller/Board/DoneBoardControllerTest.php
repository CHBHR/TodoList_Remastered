<?php

namespace App\Tests\Controller\Board;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoneBoardControllerTest extends WebTestCase
{
    public function testDoneBoardRedirectsIfNotConnected(): void
    {
        $client = static::createClient();
        $client->request('GET', '/board/done');
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function testDoneBoardIsUpWhenConnected()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user2@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/board/done');
        $this->assertSelectorTextContains('h1', 'Votre Tâches terminées');
    }
}
