<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        foreach (range(1, 40) as $i) {
            $movie = (new Movie())
                ->setTitle($faker->unique()->movie)
                ->setPoster($faker->imageUrl(400, 600, 'movies', true))
                ->setDescription($faker->text(200))
                ->setDuration(rand(100, 250))
                ->setNote(
                    rand(0, 5) + rand(0, 5) / 10
                )
                ->setCategory($this->getReference('category_' . rand(1, 8)))
                ->setReleaseDate($faker->dateTimeBetween(
                    "-50 years",
                ))
                ->setDirector($faker->name)
                ->setEntries(rand(5000, 10000000))
                ->setBudget(rand(100000, 100000000))
                ->setWebsite($faker->url);

                foreach (range(1, rand(1, 5)) as $j) {
                    $movie->addActor($this->getReference('actor_' . rand(1, 30)));
                }

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ActorFixtures::class,
        ];
    }
}