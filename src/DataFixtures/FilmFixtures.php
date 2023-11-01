<?php

namespace App\DataFixtures;

use App\Factory\FilmFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class FilmFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        FilmFactory::createMany(10);
    }
}
