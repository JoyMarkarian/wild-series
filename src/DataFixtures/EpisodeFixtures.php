<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        'Walking dead' => [
            'number' => 1,
            'title' => 'Episode 1',
            'synopsis' => 'La première saison de Walking Dead',
        ],
        'True Detective' => [
            'number' => 1,
            'title' => 'Episode 1',
            'synopsis' => 'La première saison de True Detective',
        ],
        'Stranger things' => [
            'number' => 1,
            'title' => 'Episode 1',
            'synopsis' => 'La première saison de Stranger things',
        ],
        'Game of Thrones' => [
            'number' => 1,
            'title' => 'Episode 1',
            'synopsis' => 'La première saison de Game of Thrones',
        ],
        'Les 100' => [
            'number' => 1,
            'title' => 'Episode 1',
            'synopsis' => 'La première saison de Les 100',
        ],
    ];
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $title => $episodeData) {
            $episode = new Episode();
            $episode->setNumber($episodeData['number']);
            $episode->setTitle($episodeData['title']);
            $episode->setSynopsis($episodeData['synopsis']);
            $episode->setSeason($this->getReference('season_' . $title));
            $manager->persist($episode);
            $this->addReference('episode_' . $title, $episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
