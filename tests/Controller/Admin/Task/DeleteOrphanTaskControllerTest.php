<?php

namespace App\Tests\Controller\Admin\Task;

use App\Repository\TaskRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class DeleteOrphanTaskControllerTest extends AbstractTestController
{
    private $invalidTaskId = 52841612131;

    /**
     * @test
    */
    public function deleteOrphanTaskAsAdmin()
    {
        $this->loginAsAdmin();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskTest = $taskRepository->findOneBy(['title'=>'Task 5 - not done orphan']);
        $taskTestId = $taskTest->getId();

        $crawler = $this->client->request('GET', '/admin/tasks/'.$taskTestId.'/delete');

        $this->assertResponseRedirects('/admin/task/list');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche a bien été supprimée.", $crawler->text());
    }

    /**
     * @test 
    */
    public function deletingNonExistantTaskShouldReturnNotFound()
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/tasks/' . $this->invalidTaskId . '/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
