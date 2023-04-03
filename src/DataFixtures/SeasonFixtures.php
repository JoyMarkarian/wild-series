<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS =
    [
        'Walking dead' => [
            'number' => 1,
            'year' => 2010,
            'description' => 'La première saison de Walking Dead',
        ],
        'True Detective' => [
            'number' => 1,
            'year' => 2014,
            'description' => 'La première saison de True Detective',
        ],
        'Stranger things' => [
            'number' => 1,
            'year' => 2016,
            'description' => 'La première saison de Stranger things',
        ],
        'Game of Thrones' => [
            'number' => 1,
            'year' => 2011,
            'description' => 'La première saison de Game of Thrones',
        ],
        'Les 100' => [
            'number' => 1,
            'year' => 2014,
            'description' => 'La première saison de Les 100',
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $title => $seasonData) {
            $season = new Season();
            $season->setNumber($seasonData['number']);
            $season->setYear($seasonData['year']);
            $season->setDescription($seasonData['description']);
            $season->setProgram($this->getReference('program_' . $title));
            $manager->persist($season);
            $this->addReference('season_' . $title, $season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
