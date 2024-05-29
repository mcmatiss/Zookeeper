<?php
require_once "Animal.php";
require "vendor/autoload.php";

use Carbon\Carbon;

$consoleColor = new PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor();

$dontAllowMoreThanOneAnimal = true;

$animals = [
    new Animal("Bear", "Honey",
        $consoleColor->apply("color_94", "ʕ•͡ᴥ•ʔ")),
    new Animal("Koala Bear", "Leaves of eucalyptus tree",
        $consoleColor->apply("color_130", "ʕ •ᴥ•ʔ")),
    new Animal("Penguin", "Fish",
        $consoleColor->apply("color_246", '<(")')),
    new Animal("Wildcat", "Fish",
        $consoleColor->apply("color_186", "=^-.-^=")),
    new Animal("African wild dog", "Meat",
        $consoleColor->apply("color_208", "U｡･ｪ･｡U")),
    new Animal("Monkey", "Banana",
        $consoleColor->apply("color_101", "@(*_*)@")),
    new Animal("Frog", "Insects",
        $consoleColor->apply("color_10", ":(?)")),
    new Animal("Boar", "Nuts",
        $consoleColor->apply("color_58", "(ˆ(oo)ˆ)")),
    new Animal("Owl", "Meat",
        $consoleColor->apply("color_60", "{0,0}")),
];

$foodTypes = [
    "Honey",
    "Leaves of eucalyptus tree",
    "Fish",
    "Meat",
    "Banana",
    "Insects",
    "Nuts",
];

function mood(
    int $happinessLevel,
    PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor $color
): string {
    if ($happinessLevel > 50) {
        return $color->apply("bg_color_22", "Happy");
    } else {
        return $color->apply("bg_color_88", "Sad");
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
    ->setPadding(2);
foreach ($animals as $index => $animal) {
    $animalTable
        ->addRow()
        ->addColumn($index + 1)
        ->addColumn($animal->getAnimalArt())
        ->addColumn($animal->getName())
        ->addColumn($animal->getFoodTypePreference());
}
$zooTable
    ->addHeader($consoleColor->apply("bold", "Index"))
    ->addHeader($consoleColor->apply("bold", "Animal"))
    ->addHeader($consoleColor->apply("bold", "Name"))
    ->addHeader($consoleColor->apply("bold", "Food Reserves"))
    ->addHeader($consoleColor->apply("bold", "Mood"))
    ->addHeader($consoleColor->apply("bold", "Actions"))
    ->setPadding(2);
$selectedAnimalTable
    ->addHeader($consoleColor->apply("bold", "Animal"))
    ->addHeader($consoleColor->apply("bold", "Name"))
    ->addHeader($consoleColor->apply("bold", "Food Reserves"))
    ->addHeader($consoleColor->apply("bold", "Happiness Level"))
    ->addHeader($consoleColor->apply("bold", "Mood"))
    ->addHeader($consoleColor->apply("bold", "Actions"))
    ->setPadding(2);

$zoo = [];
$animalActions =[];

do {
    if (count($animalActions) > 0) {
        foreach ($zoo as $index => $zooAnimal) {
            if ($zooAnimal->getAnimalState() === 'Working'){
                if (Carbon::now()->timestamp - $animalActions[$index] > 5) {
                    $zooAnimal->addFoodReserves(-5);
                    $zooAnimal->increaseHappinessLevel(-5);
                }
            }
            if ($zooAnimal->getAnimalState() === 'Playing'){
                if (Carbon::now()->timestamp - $animalActions[$index] > 5) {
                    $zooAnimal->addFoodReserves(-5);
                    $zooAnimal->increaseHappinessLevel(5);
                }
            }
        }
    }
    if (count($zoo) === 0) {
        $zooTable->display();
        echo $consoleColor->apply("color_240", "1. Select animal") .
            "\n2. Add animal\n" .
            "3. Exit\n";
    } else {
        foreach ($zoo as $index => $zooAnimal) {
            $zooTable
                ->addColumn($index + 1, 0, $index)
                ->addColumn($zooAnimal->getAnimalArt(), 1, $index)
                ->addColumn($zooAnimal->getName(), 2, $index)
                ->addColumn($zooAnimal->getFoodReserves() . "/100", 3, $index)
                ->addColumn(
                    mood($zooAnimal->getHappinessLevel(), $consoleColor), 4, $index
                )
                ->addColumn($zooAnimal->getAnimalState(), 5, $index);
        }
        $zooTable->display();
        echo "1. Select animal\n" .
            "2. Add animal\n" .
            "3. Exit\n";
    }
    $userMainMenuChoice = (int) readline("Enter your choice: ");
    // Select Animal
    if ($userMainMenuChoice === 1 && count($zoo) !== 0) {
        $userSelectedAnimalIndex = (int) readline("Enter animal index: ");
        if (
            $userSelectedAnimalIndex <= count($zoo) &&
            $userSelectedAnimalIndex > 0
        ) {
            $selectedAnimalTable
                ->addRow()
                ->addColumn($zoo[$userSelectedAnimalIndex - 1]->getAnimalArt(), 0, 0)
                ->addColumn($zoo[$userSelectedAnimalIndex - 1]->getName(), 1, 0)
                ->addColumn($zoo[$userSelectedAnimalIndex - 1]->getFoodReserves() . "/100", 2, 0)
                ->addColumn($zoo[$userSelectedAnimalIndex - 1]->getHappinessLevel() . "/100", 3, 0)
                ->addColumn(
                    mood(
                        $zoo[$userSelectedAnimalIndex - 1]->getHappinessLevel(), $consoleColor), 4, 0)
                ->addColumn($zoo[$userSelectedAnimalIndex - 1]->getAnimalState(), 5, 0)
                ->display();
            echo "1. Feed animal\n" .
                "2. Pet animal\n" .
                "3. Send animal to work\n" .
                "4. Send animal to play\n" .
                "5. Send animal to rest\n" .
                "6. Exit\n";
            $userInteractChoice = (int) readline("Enter your choice: ");
            switch ($userInteractChoice) {
                case $userInteractChoice === 1:
                    echo PHP_EOL;
                    foreach ($foodTypes as $index => $food) {
                        echo $index + 1 . ". $food\n";
                    }
                    $userFoodTypeChoice = (int) readline("Enter food type index: ");
                    if (
                        $foodTypes[$userFoodTypeChoice - 1] ===
                        $zoo[$userSelectedAnimalIndex - 1]->getFoodTypePreference() &&
                        $userFoodTypeChoice > 0 &&
                        $userFoodTypeChoice <= count($foodTypes)
                    ) {
                        $zoo[$userSelectedAnimalIndex - 1]->addFoodReserves(20);
                        $zooTable->addColumn(
                            $zoo[$userSelectedAnimalIndex - 1]->getFoodReserves() . "/100",
                            3, $userSelectedAnimalIndex - 1
                        );
                    } else {
                        $zoo[$userSelectedAnimalIndex - 1]->addFoodReserves(-40);
                        $zooTable->addColumn(
                            $zoo[$userSelectedAnimalIndex - 1]->getFoodReserves() . "/100",
                            3, $userSelectedAnimalIndex - 1
                        );
                        $zoo[$userSelectedAnimalIndex - 1]->increaseHappinessLevel(-20);
                        $zooTable->addColumn(
                            mood(
                                $zoo[$userSelectedAnimalIndex - 1]->getHappinessLevel(), $consoleColor),
                            4, $userSelectedAnimalIndex - 1
                        );
                    }
                    break;
                case $userInteractChoice === 2:
                    $zoo[$userSelectedAnimalIndex - 1]->increaseHappinessLevel(20);
                    $zooTable->addColumn(
                        mood($zoo[$userSelectedAnimalIndex - 1]->getHappinessLevel(), $consoleColor),
                        4, $userSelectedAnimalIndex - 1
                    );
                    break;
                case $userInteractChoice === 3:
                    $zoo[$userSelectedAnimalIndex - 1]->setAnimalState("Working");
                    $zooTable->addColumn(
                        $zoo[$userSelectedAnimalIndex - 1]->getAnimalState(), 5, $userSelectedAnimalIndex - 1
                    );
                    $animalActions[$userSelectedAnimalIndex - 1] = Carbon::now()->timestamp;
                    break;
                case $userInteractChoice === 4:
                    $zoo[$userSelectedAnimalIndex - 1]->setAnimalState("Playing");
                    $zooTable->addColumn(
                        $zoo[$userSelectedAnimalIndex - 1]->getAnimalState(), 5, $userSelectedAnimalIndex - 1
                    );
                    $animalActions[$userSelectedAnimalIndex - 1] = Carbon::now()->timestamp;
                    break;
                case $userInteractChoice === 5:
                    $zoo[$userSelectedAnimalIndex - 1]->setAnimalState("Resting");
                    $zooTable->addColumn(
                        $zoo[$userSelectedAnimalIndex - 1]->getAnimalState(), 5, $userSelectedAnimalIndex - 1
                    );
                    $animalActions[$userSelectedAnimalIndex - 1] = Carbon::now()->timestamp;
            }
        }
    }
    // Add Animal
    if ($userMainMenuChoice === 2) {
        $animalTable->display();
        echo "Enter 0 if you wish to exit.\n";
        $userAddAnimalChoice = (int) readline("Choose animal, enter index: ");
        if (
            $userAddAnimalChoice <= count($animals) &&
            $userAddAnimalChoice > 0
        ) {
            if ($dontAllowMoreThanOneAnimal) {
                if (! in_array($animals[$userAddAnimalChoice - 1], $zoo)) {
                    $zoo[] = $animals[$userAddAnimalChoice - 1];
                }
            } else {
                $zoo[] = $animals[$userAddAnimalChoice - 1];
            }
        }
    }
} while ($userMainMenuChoice !== 3);
