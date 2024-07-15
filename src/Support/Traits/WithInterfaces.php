<?php

namespace App\Support\Traits;

trait WithInterfaces
{
    public function hasImplementation(string $class, string $interface): bool
    {
        return in_array($interface, class_implements($class));
    }
}
