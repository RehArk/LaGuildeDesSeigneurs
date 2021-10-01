<?php 

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

use DateTime;
use App\Entity\Character;

class CharacterService implements CharacterServiceInterface 
{
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
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }
}
