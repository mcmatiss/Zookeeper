<?php
class Animal
{
    private string $animalArt;
    private string $name;
    private int $happinessLevel = 40;
    private string $foodTypePreference;
    private int $foodReserves = 40;
    private string $animalState = "Resting";
    public function __construct(
        string $name,
        string $foodTypePreference,
        string $animalArt = ""
    ) {
        $this->name = $name;
        $this->foodTypePreference = $foodTypePreference;
        $this->animalArt = $animalArt;
    }
    public function increaseHappinessLevel(int $happinessLevel): void
    {
        if ($this->happinessLevel < 100 || $happinessLevel < 0) {
            $this->happinessLevel += $happinessLevel;
            if ($this->happinessLevel < 0) {
                $this->happinessLevel = 0;
            }
        }
    }
    public function addFoodReserves(int $foodReserves): void
    {
        if ($this->foodReserves < 100 || $foodReserves < 0) {
            $this->foodReserves += $foodReserves;
            if ($this->foodReserves < 0) {
                $this->foodReserves = 0;
            }
        }
    }
    public function setAnimalState(string $animalState): void
    {
        $this->animalState = $animalState;
    }
    public function getAnimalArt(): string
    {
        return $this->animalArt;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getHappinessLevel(): int
    {
        return $this->happinessLevel;
    }
    public function getFoodTypePreference(): string
    {
        return $this->foodTypePreference;
    }
    public function getFoodReserves(): int
    {
        return $this->foodReserves;
    }
    public function getAnimalState(): string
    {
        return $this->animalState;
    }
}
