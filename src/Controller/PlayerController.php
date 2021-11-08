<?php

namespace App\Controller;

use App\Entity\Player;
use App\Services\PlayerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{

    private PlayerServiceInterface $playerService;

    public function __construct(PlayerServiceInterface $playerService)
    {
        $this->playerService = $playerService;
    }

    /**
     * @Route("/player", 
     * name="player", 
     * methods={"GET", "HEAD"})
     */
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('player_index');
    }

    /**
     * @Route("/player/index", 
     * name="player_index", 
     * methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('playerDisplayAll');

        $players = $this->playerService->getAll();

        return new JsonResponse($players);
    }

    /**
     * @Route("/player/create", 
     * name="player_create",
     * methods={"POST", "HEAD"}))
     */
    public function create(): Response
    {
        $this->denyAccessUnlessGranted('playerCreate');

        $player = $this->playerService->create();

        return new JsonResponse($player->toArray());
    }

    /**
     * @Route("/player/display/{identifier}", 
     * name="player_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"}))
     */
    public function display(Player $player): Response
    {
       $this->denyAccessUnlessGranted('playerDisplay', $player);

        return new JsonResponse($player->toArray());
    }

    /**
     * @Route("/player/modify/{identifier}", 
     * name="player_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT", "HEAD"}))
     */
    public function modify(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerModify', $player);

        $player = $this->playerService->modify($player);

        return new JsonResponse($player->toArray());
    }

     /**
     * @Route("/player/delete/{identifier}", 
     * name="player_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT", "HEAD"}))
     */

    public function delete(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);

        $response = $this->playerService->delete($player);

        return new JsonResponse(array('delete' => $response));
    }
}
