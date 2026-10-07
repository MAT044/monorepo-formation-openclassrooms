<?php

namespace App\Entity;

use App\Repository\ProjectMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectMemberRepository::class)]
class ProjectMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?project $project = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $member = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?project
    {
        return $this->project;
    }

    public function setProject(?project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getMember(): ?Employee
    {
        return $this->member;
    }

    public function setMember(?Employee $member): static
    {
        $this->member = $member;

        return $this;
    }
}
