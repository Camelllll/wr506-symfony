<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        foreach (range(1, 10) as $i) {
            $nationality = new Nationality();
            $nationality->setTitle($faker->country);
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}
