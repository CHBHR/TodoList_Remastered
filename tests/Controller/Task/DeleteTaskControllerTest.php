<?php

namespace App\Tests\Controller\Task;

use App\Repository\TaskRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class DeleteTaskControllerTest extends AbstractTestController
{
    private $invalidTaskId = 52841612131;

    /** 
     * @test 
    */
    public function testDeleteTaskRedirectsIfNotConnected()
    {
        $this->client->request('GET', '/tasks/{id}/delete');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    /** 
     * @test 
    */
    public function deletingNonExistantTaskShouldReturnNotFound()
    {
        $this->loginAsUser();

        $this->client->request('GET', 'tasks/' . $this->invalidTaskId . '/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /** 
     * @test 
    */
    public function deleteTaskAsUser()
    {
        $this->loginAsUser();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskTest = $taskRepository->findOneBy(['title'=>'Task 3 - not done with deadline']);
        $taskTestId = $taskTest->getId();

        $crawler = $this->client->request('GET', 'tasks/'.$taskTestId.'/delete');

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche a bien été supprimée.", $crawler->text());
    }
}
