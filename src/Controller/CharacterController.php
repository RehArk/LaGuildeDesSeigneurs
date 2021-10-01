<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Character;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends AbstractController
{

    /**
     * @Route("/character", 
     * name="character", 
     * methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    /**
     * @Route("/character/display", 
     * name="character_display"
     * methods={"GET", "HEAD"}))
     */
    public function display(): JsonResponse
    {
        $character = new Character();
        return new JsonResponse($character->toArray());
        // dump($character); // var_dump ++
        // dd($character->toArray()); // dump and die
    }
}
