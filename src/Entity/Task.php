<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private ?bool $isDone = null;

    #[ORM\Column]
    private ?bool $hasDeadLine = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $deadLine = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function isHasDeadLine(): ?bool
    {
        return $this->hasDeadLine;
    }

    public function setHasDeadLine(bool $hasDeadLine): self
    {
        $this->hasDeadLine = $hasDeadLine;

        return $this;
    }

    public function getDeadLine(): ?\DateTime
    {
        return $this->deadLine;
    }

    public function setDeadLine(?\DateTime $deadLine): self
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
