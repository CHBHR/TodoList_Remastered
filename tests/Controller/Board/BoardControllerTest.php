<?php

namespace App\Tests\Controller\Board;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\Controller\AbstractTestController;

class BoardControllerTest extends AbstractTestController
{
    /**
     * @test
     */
    public function testBoardRedirectsIfNotConnected(): void
    {
        $this->client->request('GET', '/board');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function testBoardIsUpWhenConnected()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/board');
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }

    /** 
     * @test 
    */
    public function testUserGetTasks()
    {
        $this->loginAsUser();

        $this->client->request('GET', '/board');
        
        // Get the user tasks
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userTest = $userRepository->findOneBy(['username' =>'TestUser2']);
        $taskList = $userTest->getTasks();
        static::getContainer()->get(TaskRepository::class);
        $taskTitleList = [];
        foreach($taskList as $task)
        {
            $taskTitleList[]  = $task->getTitle();
        }

        // Create comparative tasks list
        $taskListTest = [
            "Task 1 - not done without deadline",
            "Task 2 - done without deadline",
            "Task 3 - not done with deadline"
        ];

        // Compare
        $this->assertEquals($taskListTest[0], $taskTitleList[0]);
        $this->assertEquals($taskListTest[1], $taskTitleList[1]);
        $this->assertEquals($taskListTest[2], $taskTitleList[2]);
    }
}
