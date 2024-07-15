<?php

namespace App\Actions\Traits;

trait Runnable
{
    public static function run(...$args): mixed
    {
        return (new static())(...$args);
    }
}
