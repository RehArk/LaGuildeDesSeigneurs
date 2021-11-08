<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use App\Services\CharacterServiceInterface;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $this->createChar($manager);
        $this->createPlayer($manager);
       
    }

    protected function createChar(ObjectManager $manager) 
    {
         for ($i=0; $i < 10; $i++) { 
        
            $character = new Character();
            $character
                ->setKind( rand(0,1) ? 'Dame' : 'Seigneur')
                ->setName('Eldalote'.$i)
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(mt_rand(100, 200))
                ->setLife(mt_rand(10, 20))
                ->setImage('/images/eldalote.jpg')
                ->setCreation(new DateTime())
                ->setModification(new DateTime())
                ->setIdentifier(hash('sha1', uniqid()))
            ;

            $manager->persist($character);
        }

        $manager->flush();
    }

    protected function createPLayer(ObjectManager $manager) 
    {
        for ($i=0; $i < 5; $i++) { 
        
            $player = new Player();
            $player
                ->setFirstname('Vincent'.$i)
                ->setLastname('CLERC')
                ->setPassword(hash('sha1', 'password'))
                ->setEmail('vincentclercs73@gmail.com')
                ->setMirian(0)
                ->setIdentifier(hash('sha1', uniqid()))
                ->setCreation(new DateTime())
                ->setModification(new DateTime())
            ;

            $manager->persist($player);
        }

        $manager->flush();
    }
}
