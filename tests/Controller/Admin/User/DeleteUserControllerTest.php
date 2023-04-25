<?php

namespace App\Tests\Controller\Admin\User;

use App\Repository\UserRepository;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserControllerTest extends AbstractTestController
{
    private $invalidUserId = 52841612131;

    /** 
     * @test 
    */
    public function deletingNonExistantUserShouldReturnNotFound()
    {
        $this->loginAsAdmin();

        $this->client->request('GET', '/admin/users/' . $this->invalidUserId . '/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /** 
     * @test 
    */
    public function deleteUserAsAdmin()
    {
        // Add check for task anonymization.
        $this->loginAsAdmin();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $userTest = $userRepository->findOneBy(['username'=>'TestUser3']);
        $userTestId = $userTest->getId();

        $crawler = $this->client->request('GET', '/admin/users/'.$userTestId.'/delete');

        $this->assertResponseRedirects('/admin/users/list');
        $crawler = $this->client->followRedirect();

        $this->assertStringContainsString("L' utilisateur à bien été supprimer", $crawler->text());
    }
}