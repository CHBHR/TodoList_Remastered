<?php

namespace App\Tests\Controller\Admin\User;

use App\Repository\UserRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class EditUserControllerTest extends AbstractTestController
{
    private $invalidUserId = 52841612131;

    /** 
     * @test 
    */
    public function editingNonExistantTaskShouldReturnNotFound()
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/users/' . $this->invalidUserId . '/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /** 
     * @test 
    */
    public function testEditUserAsAdmin()
    {
        $this->loginAsAdmin();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $userTest = $userRepository->findOneBy(['username'=>'TestUser3']);
        $userTestId = $userTest->getId();
        
        $crawler = $this->client->request('GET', '/admin/users/'.$userTestId.'/edit');

        //button is called 'ajouter'
        $buttonCrawlerNode = $crawler->selectButton("Modifier");

        $form = $buttonCrawlerNode->form();

        $form['user[username]']='TestCreatedUser';
        $form['user[email]']='testcreateduser@gmail.com';
        $form['user[password][first]']='test';
        $form['user[password][second]']='test';

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/users/list');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("L'utilisateur a bien été modifié", $crawler->text());
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }
}