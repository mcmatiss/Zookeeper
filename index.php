<?php
require_once 'Animal.php';
require 'vendor/autoload.php';

use Carbon\Carbon;

$consoleColor = new PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor();

$animals = [
    new Animal('Bear', 'Honey', $consoleColor->apply("color_94", 'ʕ•͡ᴥ•ʔ')),
    new Animal('Koala Bear', 'Leaves of eucalyptus tree', $consoleColor->apply("color_130", 'ʕ •ᴥ•ʔ')),
    new Animal('Penguin', 'Fish', $consoleColor->apply("color_246", '<(")')),
    new Animal('Wildcat', 'Fish', $consoleColor->apply("color_186", '=^-.-^=')),
    new Animal('African wild dog', 'Meat', $consoleColor->apply("color_208", 'U｡･ｪ･｡U')),
    new Animal('Monkey', 'Banana', $consoleColor->apply("color_101", '@(*_*)@')),
    new Animal('Frog', 'Insects', $consoleColor->apply("color_10", ':(?)')),
    new Animal('Boar', 'Nuts', $consoleColor->apply("color_58", '(ˆ(oo)ˆ)')),
    new Animal('Owl', 'Meat', $consoleColor->apply("color_60", '{0,0}'))
];

function mood(int $happinessLevel, PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor $color): string
{
    if ($happinessLevel > 5) {
        return $color->apply("bg_color_22", 'Happy');
    } else {
        return $color->apply("bg_color_88", 'Sad');
    }
}
$animalTable = new LucidFrame\Console\ConsoleTable();
$zooTable = new LucidFrame\Console\ConsoleTable();
$selectedAnimalTable = new LucidFrame\Console\ConsoleTable();
$animalTable
    ->addHeader($consoleColor->apply("bold", "Index"))
    ->addHeader($consoleColor->apply("bold", "Animal"))
    ->addHeader($consoleColor->apply("bold", "Name"))
    ->addHeader($consoleColor->apply("bold", "Food Preference"))
    ->setPadding(2)
;
foreach ($animals as $index => $animal) {
    $animalTable
        ->addRow()
        ->addColumn($index+1)
        ->addColumn($animal->getAnimalArt())
        ->addColumn($animal->getName())
        ->addColumn($animal->getFoodTypePreference())
    ;
}
$zooTable
    ->addHeader($consoleColor->apply("bold", "Index"))
    ->addHeader($consoleColor->apply("bold", "Animal"))
    ->addHeader($consoleColor->apply("bold", "Name"))
    ->addHeader($consoleColor->apply("bold", "Food Reserves"))
    ->addHeader($consoleColor->apply("bold", "Mood"))
    ->addHeader($consoleColor->apply("bold", "Actions"))
    ->setPadding(2)
;
$selectedAnimalTable
    ->addHeader($consoleColor->apply("bold", "Animal"))
    ->addHeader($consoleColor->apply("bold", "Name"))
    ->addHeader($consoleColor->apply("bold", "Food Reserves"))
    ->addHeader($consoleColor->apply("bold", "Happiness Level"))
    ->addHeader($consoleColor->apply("bold", "Mood"))
    ->addHeader($consoleColor->apply("bold", "Actions"))
    ->setPadding(2)
;
$zoo = [];
$animalIndex = 0;

do {
    $zooTable->display();
    // Show Time

    // User Menu
    if (count($zoo) === 0) {
        echo $consoleColor->apply("color_240", '1. Select animal') .
            "\n2. Add animal\n" .
            "3. Exit\n"
        ;
    } else {
        echo "1. Select animal\n" .
            "2. Add animal\n" .
            "3. Exit\n"
        ;
    }
    $userMainMenuChoice = (int) readline("Enter your choice: ");
    if ($userMainMenuChoice === 1 && count($zoo) !== 0) {
        $userSelectedAnimalIndex = (int) readline("Enter animal index: ");
        if ($userSelectedAnimalIndex <= count($zoo) && $userSelectedAnimalIndex > 0) {
            $selectedAnimal = $selectedAnimalTable;
            $selectedAnimal
                ->addRow()
                ->addColumn($zoo[$userSelectedAnimalIndex-1]->getAnimalArt())
                ->addColumn($zoo[$userSelectedAnimalIndex-1]->getName())
                ->addColumn($zoo[$userSelectedAnimalIndex-1]->getFoodReserves() . "/100")
                ->addColumn($zoo[$userSelectedAnimalIndex-1]->getHappinessLevel() . "/10")
                ->addColumn(mood($zoo[$userSelectedAnimalIndex-1]->getHappinessLevel(), $consoleColor))
                ->addColumn($zoo[$userSelectedAnimalIndex-1]->getAnimalState())
                ->display();
        }
        echo "1. Feed animal\n" .
            "2. Pet animal\n" .
            "3. Send animal to work\n" .
            "4. Send animal to play\n" .
            "5. Send animal to rest\n" .
            "6. Exit\n"
        ;
        $userInteractChoice = (int) readline("Enter your choice");
    }
    if ($userMainMenuChoice === 2) {
        $animalTable->display();
        $userAddAnimalChoice = (int) readline("Choose animal: ");
        if ($userAddAnimalChoice <= count($animals) && $userAddAnimalChoice > 0) {
            $zoo[] = $animals[$userAddAnimalChoice-1];
            $zooTable
                ->addRow()
                ->addColumn($animalIndex+1)
                ->addColumn($zoo[$animalIndex]->getAnimalArt())
                ->addColumn($zoo[$animalIndex]->getName())
                ->addColumn($zoo[$animalIndex]->getFoodReserves() . "/100")
                ->addColumn(mood($zoo[$animalIndex]->getHappinessLevel(), $consoleColor))
                ->addColumn($zoo[$animalIndex]->getAnimalState())
            ;
            $animalIndex++;
        }
    }
} while ($userMainMenuChoice !== 3);

printf("Now: %s", Carbon::now());
