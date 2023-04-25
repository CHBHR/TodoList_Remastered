<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

    private $date;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->date = new \DateTime();
    }

    public function testCreatedAt()
    {
        $this->task->setCreatedAt($this->date);
        $this->assertSame($this->date, $this->task->getCreatedAt());
    }

    public function testId()
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('Test du titre');
        $this->assertSame($this->task->getTitle(), 'Test du titre');
    }

    public function testContent()
    {
        $this->task->setContent('Test du contenu');
        $this->assertSame($this->task->getContent(), 'Test du contenu');
    }

    public function testHasDeadLine()
    {
        $this->task->setHasDeadLine(true);
        $this->assertSame($this->task->isHasDeadLine(), true);
    }

    public function testSetDeadLine()
    {
        $this->task->setDeadLine($this->date);
        $this->assertSame($this->task->getDeadLine(), $this->date);
    }

    public function testSetIdDone()
    {
        $this->task->setIsDone(true);
        $this->assertSame($this->task->isIsDone(), true);
    }

    public function testIsDone()
    {
        $this->task->setIsDone(true);
        $this->assertEquals($this->task->isIsDone(), true);
    }

    public function testUser()
    {
        $this->task->setUser(new User());
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }
}
