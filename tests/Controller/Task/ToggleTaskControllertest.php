<?php

namespace App\Tests\Controller\Task;

use App\Repository\TaskRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class ToggleTaskControllerTest extends AbstractTestController
{
    private $invalidTaskId = 52841612131;

    /** 
     * @test 
    */
    public function toggleNonExistantTaskShouldReturnNotFound()
    {
        $this->loginAsUser();

        $this->client->request('GET', 'tasks/' . $this->invalidTaskId . '/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /** 
     * @test 
    */
    public function testToggleTaskToDone()
    {
        $this->loginAsUser();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskTest = $taskRepository->findOneBy(['title'=>'Task 1 - not done without deadline']);
        $taskTestId = $taskTest->getId();
        $taskTestName =  $taskTest->getTitle();
        
        $crawler = $this->client->request('GET', '/tasks/'.$taskTestId.'/toggle');

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche \"".$taskTestName."\" a bien été marquée comme faite.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
        
    }

    /** 
     * @test 
    */
    public function testToggleTaskToNotDone()
    {
        $this->loginAsUser();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskTest = $taskRepository->findOneBy(['title'=>'Task 2 - done without deadline']);
        $taskTestId = $taskTest->getId();
        $taskTestName =  $taskTest->getTitle();
        
        $crawler = $this->client->request('GET', '/tasks/'.$taskTestId.'/toggle');

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche \"".$taskTestName."\" a bien été remise sur votre tableau.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }
}
