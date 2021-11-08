<?php 

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManager;

class CharacterService implements CharacterServiceInterface 
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll() : array 
    {
        $characters = [];

        

        return $characters;
    }

    public function create()
    {
        $character = new Character();
        $character
            ->setKind('Dame')
            ->setName('Eldalote')
            ->setSurname('Fleur elfique')
            ->setCaste('Elfe')
            ->setKnowledge('Arts')
            ->setIntelligence(120)
            ->setLife(12)
            ->setImage('/images/eldalote.jpg')
            ->setCreation(new DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
        ;

        $this->em->persist($character);
        $this->em->flush();
        
        return $character;
    }
}
