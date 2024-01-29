<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        foreach (range(1, 40) as $i) {
            $movie = new Movie();
        
            // Utilisez Faker pour générer des données aléatoires
            $movie->setTitle(implode(' ', $faker->words($faker->numberBetween(1, 4))));
            $movie->setReleaseDate($faker->dateTimeBetween('-30 years', 'now'));
            $movie->setDuration($faker->numberBetween(60, 240));
            $movie->setDescription(implode("\n", $faker->paragraphs($faker->numberBetween(1, 3))));
        
            $movie->setCategory($this->getReference('category_' . $faker->numberBetween(1, 5)));
        
            $actors = [];
            foreach (range(1, $faker->numberBetween(2, 6)) as $j) {
                $actor = $this->getReference('actor_' . $faker->numberBetween(1, 10));
                if (!in_array($actor, $actors)) {
                    $actors[] = $actor;
                    $movie->addActor($actor);
                }
            }
        
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ActorFixtures::class,
        ];
    }
}
