<?php

namespace App\Test\DataFixtures;

use App\Entity\Task;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $createdAt = new \DateTime();
        $interval = 'P3D';
        $deadline = $createdAt->add(new DateInterval($interval));

        $task1 = new Task();
        $task1->setUser($this->getReference('user2'));
        $task1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque molestie placerat metus, pellentesque tristique massa maximus sodales.');
        $task1->setCreatedAt($createdAt);
        $task1->setTitle('Task 1 - not done without deadline');
        $task1->setIsDone(false);
        $task1->setHasDeadLine(false);
        $manager->persist($task1);

        $task2 = new Task();
        $task2->setUser($this->getReference('user2'));
        $task2->setContent('Curabitur egestas ex ac metus blandit, in imperdiet justo porta. Donec commodo magna at metus lobortis pharetra. Donec consectetur tristique rutrum.');
        $task2->setCreatedAt($createdAt);
        $task2->setTitle('Task 2 - done without deadline');
        $task2->setIsDone(true);
        $task2->setHasDeadLine(false);
        $manager->persist($task2);

        $task3 = new Task();
        $task3->setUser($this->getReference('user2'));
        $task3->setContent('Nulla tortor mauris.');
        $task3->setCreatedAt($createdAt);
        $task3->setTitle('Task 3 - not done with deadline');
        $task3->setIsDone(false);
        $task3->setHasDeadLine(true);
        $task3->setDeadLine($deadline);
        $manager->persist($task3);

        $task4 = new Task();
        $task4->setUser($this->getReference('user1'));
        $task4->setContent('Donec vitae convallis massa.');
        $task4->setCreatedAt($createdAt);
        $task4->setTitle('Task 4 - not done with deadline');
        $task4->setIsDone(false);
        $task4->setHasDeadLine(true);
        $task4->setDeadLine($deadline);
        $manager->persist($task4);

        $task5 = new Task();
        $task5->setUser(NULL);
        $task5->setContent('Morbi iaculis arcu vel lobortis tristique. Integer id euismod augue, in gravida elit.');
        $task5->setCreatedAt($createdAt);
        $task5->setTitle('Task 5 - not done orphan');
        $task5->setIsDone(false);
        $task5->setHasDeadLine(false);
        $manager->persist($task5);

        $task6 = new Task();
        $task6->setUser($this->getReference('user3'));
        $task6->setContent('Donec vitae convallis massa.');
        $task6->setCreatedAt($createdAt);
        $task6->setTitle('Task 6 - not done with deadline');
        $task6->setIsDone(false);
        $task6->setHasDeadLine(true);
        $task6->setDeadLine($deadline);
        $manager->persist($task6);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}