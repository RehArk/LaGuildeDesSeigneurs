<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Character;
use App\Services\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

Use Nelmio\ApiDocBundle\Annotation\Model;
Use OpenApi\Annotations as OA;

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
     * @OA\Response(
     *  response=302,
     *  description="Redirect",
     * )
     * 
     * @OA\Tag(name="character")
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
     * 
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterDisplayAll');

        $characters = $this->characterService->getAll();

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    /**
     * Displays Characters by their intelligence level
     *
     * @Route("/character/index/intelligence/{intelligence}",
     *     name="character_api_intelligence_level",
     *     requirements={"intelligence": "^([0-9]{1,3})$"},
     *     methods={"GET", "HEAD"}
     * )
     */
    public function indexWithIntelligenceLevel(int $intelligence)
    {
        $this->denyAccessUnlessGranted('characterDisplayAll');

        $characters = $this->characterService->getAllByIntelligenceLevel($intelligence);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

     /**
     * @Route("/character/create", 
     * name="character_create",
     * methods={"POST", "HEAD"})
     * 
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     * 
     * @OA\Tag(name="character")
     */
    public function create(Request $request) : JsonResponse
    {
        $this->denyAccessUnlessGranted('characterCreate');

        $character = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * @Route("/character/display/{identifier}", 
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"}))
     * @Entity("character", expr="repository.findOneByIdentifier(identifier)")
     * @OA\Parameter(
     *  name="identifier",
     *  in="path",
     *  description="identifier for the character",
     *  required=true
     * )
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     */
    public function display(Character $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * @Route("/character/modify/{identifier}", 
     * name="character_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT", "HEAD"}))
     * @OA\Response(
     *  response=202,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     */
    public function update(Character $character, Request $request) : JsonResponse
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character, $request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }
    
    /**
     * @Route("/character/delete/{identifier}", 
     * name="character_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE", "HEAD"}))
     * @OA\Response(
     *  response=202,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     */
    public function delete(Character $character) : JsonResponse
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
     * 
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @Model(type=Character::class)
     * )
     * @OA\Response(
     *  response=403,
     *  description="Access denied",
     * )
     * @OA\Response(
     *  response=404,
     *  description="Not found",
     * )
     * @OA\Tag(name="character")
     * 
     * @OA\Tag(name="character")
     * 
     */
    public function images(int $number, string $kind = null) : JsonResponse
    {
        $this->denyAccessUnlessGranted('characterImage');

        $image = $this->characterService->getImages($number, $kind);

        return new JsonResponse($image);
    }

}
