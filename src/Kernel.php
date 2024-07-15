<?php

namespace App;

use App\Providers\AnimeFireProvider;
use App\Providers\AnimesOnlineCCProvider;
use App\Providers\SuperflixProvider;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public const PROVIDERS = [
        'superflix' => SuperflixProvider::class,
        'animesonlinecc' => AnimesOnlineCCProvider::class,
        'animefire' => AnimeFireProvider::class,
    ];
}
