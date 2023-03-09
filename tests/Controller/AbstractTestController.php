<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestController extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp(): void
    {     
        $this->client = static::createClient();
    }

    protected function loginAsAdmin()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@test.com');
        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    protected function loginAsUser()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user2@test.com');
        return $this->client->loginUser($testUser);
    }

    // public function testRedirectsIfNotConnected(string $method,string $url)
    // {
    //     $this->client->request($method, $url);
    //     $this->client->followRedirect();
    //     return $this->assertSelectorTextContains('h1', 'Connexion');
    // }

}