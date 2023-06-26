<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CatImportModel
{

    #[SerializedName('Oznak.')]
    private ?string $chip = '';
    #[SerializedName('Nazwa')]
    private string $name = '';
    #[SerializedName('Maść')]
    private string $colour = '';
    #[SerializedName('Płeć')]
    private string $gender = '';
    #[SerializedName('Miejsce pobytu')]
    private string $room = '';

    /**
     * @return string
     */
    public function getChip(): string
    {
        return $this->chip;
    }

    /**
     * @param string $chip
     * @return CatImportModel
     */
    public function setChip(string $chip): CatImportModel
    {
        $this->chip = $chip;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CatImportModel
     */
    public function setName(string $name): CatImportModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getColour(): string
    {
        return $this->colour;
    }

    /**
     * @param string $colour
     * @return CatImportModel
     */
    public function setColour(string $colour): CatImportModel
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return CatImportModel
     */
    public function setGender(string $gender): CatImportModel
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * @param string $room
     * @return CatImportModel
     */
    public function setRoom(string $room): CatImportModel
    {
        $this->room = $room;
        return $this;
    }


}