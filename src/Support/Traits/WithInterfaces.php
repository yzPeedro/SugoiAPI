<?php

namespace App\Support\Traits;

use function WyriHaximus\listClassesInDirectory;

trait WithInterfaces
{
    public function hasImplementation(string $class, string $interface): bool
    {
        return in_array($interface, class_implements($class));
    }

    public function getProvidersFromDirectory(): array
    {
        $classes = iterator_to_array(listClassesInDirectory(__DIR__.'/../../Providers'));

        $filteredClasses = array_filter($classes, function ($class) {
            return !preg_match('/Interface$/', $class);
        });

        return array_values($filteredClasses);
    }
}
