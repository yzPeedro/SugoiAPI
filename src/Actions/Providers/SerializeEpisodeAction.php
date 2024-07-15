<?php

namespace App\Actions\Providers;

use App\Actions\Traits\Runnable;

class SerializeEpisodeAction
{
    use Runnable;

    public function __invoke(int $episode): string|int
    {
        return $episode < 10 ? '0'.$episode : $episode;
    }
}
