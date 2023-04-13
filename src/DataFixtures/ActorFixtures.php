<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $programs = []; // Tableau pour stocker les programmes créés

        for ($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);

            for ($j = 0; $j < 3; $j++) {
                $programTitle = array_rand(ProgramFixtures::PROGRAMS);
                $programData = ProgramFixtures::PROGRAMS[$programTitle];

                // Vérifier si le programme existe déjà
                if (!isset($programs[$programTitle])) {
                    $program = new Program();
                    $program->setTitle($programTitle);
                    $program->setSynopsis($programData['synopsis']);
                    $program->setCategory($this->getReference($programData['category']));
                    $programs[$programTitle] = $program;
                    $manager->persist($program);
                } else {
                    $program = $programs[$programTitle];
                }

                $currentActor = $this->getReference('actor_' . $i);
                $currentActor->addProgram($program);
            }
        }

        $manager->flush();
    }
    
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}