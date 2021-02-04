<?php


namespace App\Entity;


use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Boolean;

class StudentSearch
{
    private ?string $name = '';

    private ?Collection $house = null;

    private ?bool $isTeacher = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection|null
     */
    public function getHouse(): ?Collection
    {
        return $this->house;
    }

    /**
     * @param Collection|null $house
     */
    public function setHouse(?Collection $house): void
    {
        $this->house = $house;
    }

    /**
     * @return bool|null
     */
    public function getIsTeacher(): ?bool
    {
        return $this->isTeacher;
    }

    /**
     * @param bool|null $isTeacher
     */
    public function setIsTeacher(?bool $isTeacher): void
    {
        $this->isTeacher = $isTeacher;
    }

}