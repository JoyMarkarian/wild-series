<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',

    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont CategoryFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}