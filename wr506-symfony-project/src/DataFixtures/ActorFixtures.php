<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Xylis\FakerCinema\Provider\Person;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reward = [
            'Canard d\'Or',
            'Canard de Bronze',
            'Canard d\'Argent',
            'Canard de Diamant',
            'Canard de D\'Emeraude',
            'Canard de De Saphire',
            'Canard de De Platine',
        ];

        $faker = FakerFactory::create('fr_FR');
        $faker->addProvider(new Person($faker));

        foreach (range(1, 30) as $i) {
            $fullname = $faker->unique()->actor;
            $actor = (new Actor())
                ->setBirthday($faker->dateTimeBetween('-80 years'))
                ->setReward($reward[rand(0, 6)])
                ->setFirstName(substr($fullname, 0, strpos($fullname, ' ')))
                ->setLastName(substr($fullname, strpos($fullname, ' ') + 1))
                ->setNationality($this->getReference('nationality_' . rand(1, 5)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NationalityFixtures::class,
        ];
    }
}
