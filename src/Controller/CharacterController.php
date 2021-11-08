<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Character;
use App\Services\CharacterServiceInterface;

class CharacterController extends AbstractController
{

    private CharacterServiceInterface $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

     /**
     * 
     * @Route("/",
     * name="",
     * methods={"GET", "HEAD"})
     * 
     * @Route("/character", 
     * name="character", 
     * methods={"GET", "HEAD"})
     * 
     */
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index", 
     * name="character_index", 
     * methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterDisplayAll');

        $characters = $this->characterService->getAll();

        return new JsonResponse($characters);
    }

     /**
     * @Route("/character/create", 
     * name="character_create",
     * methods={"POST", "HEAD"})
     */
    public function create()
    {
        $this->denyAccessUnlessGranted('characterCreate');

        $character = $this->characterService->create();

        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/display/{identifier}", 
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"}))
     */
    public function display(Character $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }
}
