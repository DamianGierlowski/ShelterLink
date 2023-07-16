<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class AnimalImportModel
{

    #[SerializedName('chip')]
    private ?string $chip = '';
    #[SerializedName('nazwa')]
    private string $name = '';
    #[SerializedName('masc')]
    private string $colour = '';
    #[SerializedName('plec')]
    private string $gender = '';
    #[SerializedName('miejsce')]
    private string $room = '';
    #[SerializedName('Wiek')]
    private string $birthday = '';
    #[SerializedName('Przyjecie')]
    private string $admission = '';


    public function getChip(): string
    {
        return $this->chip;
    }

    public function setChip(string $chip): AnimalImportModel
    {
        $this->chip = $chip;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AnimalImportModel
    {
        $this->name = $name;
        return $this;
    }

    public function getColour(): string
    {
        return $this->colour;
    }

    public function setColour(string $colour): AnimalImportModel
    {
        $this->colour = $colour;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): AnimalImportModel
    {
        $this->gender = $gender;
        return $this;
    }

    public function getRoom(): string
    {
        return $this->room;
    }

    public function setRoom(string $room): AnimalImportModel
    {
        $this->room = $room;
        return $this;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): AnimalImportModel
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getAdmission(): string
    {
        return $this->admission;
    }

    public function setAdmission(string $admission): AnimalImportModel
    {
        $this->admission = $admission;
        return $this;
    }


}