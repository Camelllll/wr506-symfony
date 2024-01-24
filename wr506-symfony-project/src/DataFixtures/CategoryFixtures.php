<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        // Génère moi 5 objets Category fictifs
        foreach (range(1, 5) as $i) {
            $category = new Category();
            $category->setName($faker->word); // Utilise Faker pour générer un nom de catégorie fictif
            $manager->persist($category);
            $this->addReference('category_' . $i, $category); // "expose" l'objet à l'extérieur de la classe pour les liaisons avec Movie
        }

        $manager->flush();
    }
}
