<?php
class Animal
{
    private string $animalArt;
    private string $name;
    private int $happinessLevel = 6;
    private string $foodTypePreference;
    private int $foodReserves = 10;
    private string $animalState = 'Resting';
    public function __construct(string $name, string $foodTypePreference, string $animalArt = '')
    {
        $this -> name = $name;
        $this -> foodTypePreference = $foodTypePreference;
        $this -> animalArt = $animalArt;
    }
    private function setHappinessLevel(int $happinessLevel): void
    {
        $this -> happinessLevel = $happinessLevel;
    }
    private function setFoodReserves(string $foodReserves): void
    {
        $this -> foodReserves = $foodReserves;
    }
    private function setAnimalState(string $animalState): void
    {
        $this -> animalState = $animalState;
    }
    public function getAnimalArt(): string
    {
        return $this -> animalArt;
    }
    public function getName(): string
    {
        return $this -> name;
    }
    public function getHappinessLevel(): int
    {
       return $this -> happinessLevel;
    }
    public function getFoodTypePreference(): string
    {
        return $this -> foodTypePreference;
    }
    public function getFoodReserves(): int
    {
        return $this -> foodReserves;
    }
    public function getAnimalState(): string
    {
        return $this -> animalState;
    }
}