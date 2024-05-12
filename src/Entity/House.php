<?php

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:HouseRepository::class)]
class House
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private int $id;

    #[ORM\Column(type:"string", length:255)]
    private string $name;

    #[ORM\OneToMany(targetEntity:Student::class, mappedBy:"house", orphanRemoval:true)]
    private Collection $students;

    #[ORM\OneToOne(targetEntity:Teacher::class, mappedBy:"houseHeadTeacher", cascade:["persist", "remove"])]
    private Teacher $headTeacher;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

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

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setHouse($this);
        }
        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getHouse() === $this) {
                $student->setHouse(null);
            }
        }
        return $this;
    }

    public function getHeadTeacher(): ?Teacher
    {
        return $this->headTeacher;
    }

    public function setHeadTeacher(?Teacher $headTeacher): self
    {
        // unset the owning side of the relation if necessary
        if ($headTeacher === null && $this->headTeacher !== null) {
            $this->headTeacher->setHouseHeadTeacher(null);
        }
        // set the owning side of the relation if necessary
        if ($headTeacher !== null && $headTeacher->getHouseHeadTeacher() !== $this) {
            $headTeacher->setHouseHeadTeacher($this);
        }
        $this->headTeacher = $headTeacher;
        return $this;
    }
}
