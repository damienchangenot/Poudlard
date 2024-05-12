<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private int $id;

    #[ORM\Column(type:"string", length:255)]
    private string $name;

    #[ORM\OneToOne(targetEntity:House::class, inversedBy:"headTeacher", cascade:["persist", "remove"])]
    private ?House $houseHeadTeacher;


    #[ORM\OneToOne(targetEntity:User::class, inversedBy:"teacher", cascade:["persist", "remove"])]
    #[ORM\JoinColumn(nullable:false)]
    private User $user;


    #[ORM\OneToOne(targetEntity:Subject::class, mappedBy:"teacher", cascade:["persist", "remove"])]
    private ?Subject $subject;

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

    public function getHouseHeadTeacher(): ?House
    {
        return $this->houseHeadTeacher;
    }

    public function setHouseHeadTeacher(?House $houseHeadTeacher): self
    {
        $this->houseHeadTeacher = $houseHeadTeacher;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): self
    {
        // set the owning side of the relation if necessary
        if ($subject->getTeacher() !== $this) {
            $subject->setTeacher($this);
        }

        $this->subject = $subject;

        return $this;
    }
}
