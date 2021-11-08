<?php 

namespace App\Services;

use DateTime;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService implements PlayerServiceInterface
{

    public function __construct(
        PlayerRepository $PlayerRepository,
        EntityManagerInterface $em
    )
    {
        $this->playerRepository = $PlayerRepository;
        $this->em = $em;
    }

    public function getAll() : array 
    {
        $players = [];

        $response = $this->playerRepository->findAll();
        foreach ($response as $player) {
            $players[] = $player->toArray();
        }

        return $players;
    }

    public function create()
    {
        $player = new Player();
        $player
            ->setFirstname('Vincent')
            ->setLastname('CLERC')
            ->setEmail('vincentclercs73@gmail.com')
            ->setPassword(hash('sha1', 'password'))
            ->setMirian(0)
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();
        
        return $player;
    }

    public function modify(Player $player)
    {
        $player
            ->setFirstname('Vincent')
            ->setLastname('CLERC')
            ->setEmail('vincentclercs73@gmail.com')
            ->setMirian(0)
            ->setModification(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();
        
        return $player;
    }

    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();
        return true;
    }
}