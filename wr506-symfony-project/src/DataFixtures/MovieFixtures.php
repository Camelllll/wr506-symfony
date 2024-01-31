<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 40) as $i) {
            $movie = new Movie();
        
            // Utilisez des valeurs statiques pour les données
            $movie->setTitle('Titre ' . $i);
            $movie->setReleaseDate(new \DateTime('now'));
            $movie->setDuration(rand(60, 240));
            $movie->setDescription('Description ' . $i);
            $movie->setNote(rand(1, 5));
            $movie->setEntries(rand(1000, 1000000));
            $movie->setBudget(rand(1000000, 100000000));
            $movie->setWebsite('https://www.google.com');

            
        
            $movie->setCategory($this->getReference('category_' . rand(1, 5)));
        
            $actors = [];
            foreach (range(1, rand(2, 6)) as $j) {
                $actor = $this->getReference('actor_' . rand(1, 10));
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