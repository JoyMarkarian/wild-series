<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        'Walking dead' => [
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Action',
        ],
        'True Detective' => [
            'synopsis' => 'Des meurtres envahissent la terre',
            'category' => 'category_Action',
        ],
        'Stranger things' => [
            'synopsis' => 'Des monstres envahissent la terre',
            'category' => 'category_Fantastique',
        ],
        'Game of Thrones' => [
            'synopsis' => 'Des dragons envahissent la terre',
            'category' => 'category_Fantastique',
        ],
        'Les 100' => [
            'synopsis' => 'Des jeunes gens enlevés par des extraterrestres',
            'category' => 'category_Aventure',
        ],

    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $title => $programData) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category']));
            $manager->persist($program);
            $this->addReference('program_' . $title, $program);
        }  
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }
}