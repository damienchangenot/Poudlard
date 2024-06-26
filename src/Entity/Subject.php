<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass:SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private int $id;

    #[ORM\Column(type:"string", length:255)]
    private string $name;

    #[ORM\OneToOne(targetEntity:Teacher::class, inversedBy:"subject", cascade:["persist", "remove"])]
    #[ORM\JoinColumn(nullable:false)]
    private Teacher $teacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }
}
