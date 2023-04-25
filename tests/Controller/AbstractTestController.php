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
        // Retrieve the test user.
        $testUser = $userRepository->findOneByEmail('user1@test.com');
        // Simulate $testUser being logged in.
        return $this->client->loginUser($testUser);
    }

    protected function loginAsUser()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user2@test.com');
        return $this->client->loginUser($testUser);
    }
}
