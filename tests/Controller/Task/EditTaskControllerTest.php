<?php

namespace App\Tests\Controller\Task;

use App\Repository\TaskRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class EditTaskControllerTest extends AbstractTestController
{
    private $invalidTaskId = 52841612131;

    /** 
     * @test
    */
    public function editingNonExistantTaskShouldReturnNotFound()
    {
        $this->loginAsUser();

        $this->client->request('GET', 'tasks/' . $this->invalidTaskId . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /** 
     * @test
    */
    public function testEditTask()
    {
        $this->loginAsUser();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $taskTest = $taskRepository->findOneBy(['title'=>'Task 1 - not done without deadline']);
        $taskTestId = $taskTest->getId();
        
        $crawler = $this->client->request('GET', 'tasks/'.$taskTestId.'/edit');

        $buttonCrawlerNode = $crawler->selectButton("Modifier");

        $form = $buttonCrawlerNode->form();

        $form['task[title]'] ='titre de test modifié';
        $form['task[content]'] ='contenu de test modifié';
        $form['task[hasDeadLine]'] =false;

        $this->client->submit($form);

        $this->assertResponseRedirects('/board');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("La tâche a bien été modifiée.", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Votre tableau Todo List');
    }
}
