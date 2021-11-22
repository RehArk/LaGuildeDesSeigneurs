<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Character;
use App\Services\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;

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
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate');

        $characters = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
        // return new JsonResponse($character->toArray());
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

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
        // return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/modify/{identifier}", 
     * name="character_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT", "HEAD"}))
     */
    public function update(Character $character, Request $request)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character, $request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
        // return new JsonResponse($character->toArray());
    }
    
    /**
     * @Route("/character/delete/{identifier}", 
     * name="character_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE", "HEAD"}))
     */
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $response));
    }

    /**
     * @Route("/character/image/{kind}/{number}", 
     * name="character_image_with_kind",
     * requirements={"identifier": "^([0-9]{1,2})$"},
     * methods={"GET", "HEAD"}))
     * 
     * @Route("/character/image/{number}", 
     * name="character_image",
     * requirements={"identifier": "^([0-9]{1,2})$"},
     * methods={"GET", "HEAD"}))
     */
    public function images(int $number, string $kind = null)
    {
        $this->denyAccessUnlessGranted('characterImage');

        $image = $this->characterService->getImages($number, $kind);

        return new JsonResponse($image);
    }

}
