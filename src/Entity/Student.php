<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[Vich\Uploadable]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:'string', length:255)]
    private string $name;

    #[ORM\Column(type:'string', length:255)]
    private string $picture;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'picture')]
    #[Assert\File(maxSize:"1m", mimeTypes:["image/jpeg", "image/png", "image/jpg"])]
    private ?File $pictureFile = null;

    #[ORM\Column(type:'datetime', nullable:true)]
    private ?DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity:House::class, inversedBy:'students')]
    #[ORM\JoinColumn(nullable:true)]
    private ?House $house;


    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $subject;


    #[ORM\OneToOne(targetEntity:User::class, inversedBy:"student", cascade:["persist", "remove"])]
    #[ORM\JoinColumn(nullable:true)]
    private ?User $user;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

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

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function setPictureFile(File $images = null):void
    {
        $this->pictureFile = $images;
        if ($images) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

}
