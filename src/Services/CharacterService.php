<?php 

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

use DateTime;
use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManager;

class CharacterService implements CharacterServiceInterface 
{

    public function __construct(
        CharacterRepository $characterRepository,
        EntityManagerInterface $em
    )
    {
        $this->characterRepository = $characterRepository;
        $this->em = $em;
    }

    public function getAll() : array 
    {
        $characters = [];

        $response = $this->characterRepository->findAll();
        foreach ($response as $character) {
            $characters[] = $character->toArray();
        }

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

    public function modify(Character $character) 
    {
        $character
            ->setKind('Seigneur')
            ->setName('Gorthol')
            ->setSurname('Homme de terreur')
            ->setCaste('Chevalier')
            ->setKnowledge('Diplomatie')
            ->setIntelligence(110)
            ->setLife(13)
            ->setImage('/images/gorthol.jpg')
        ;

        $this->em->persist($character);
        $this->em->flush();
        
        return $character;
    }

    public function delete(Character $character) 
    {

        $this->em->remove($character);
        $this->em->flush();
        return true;

    }
}
