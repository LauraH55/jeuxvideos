<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Game;

class GameController extends AbstractController
{

  const LIMIT = 20;

    /**
     * @Route("/", name="games")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)

    {
        $games = $this->getDoctrine()
        ->getRepository(Game::class)
        ->findBY([],['name' => 'ASC']);

        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }


    /**
   * @Route("/game/{id}", name="game")
   * @param $id
   * @return Response
   */
  public function game($id)
  {
    $games = $this->getDoctrine()
    ->getRepository(Game::class)
    ->find($id);

    if (!$games) {
      return $this->redirectToRoute('games');
    }


    return $this->render('game/game.html.twig', [
        'game' => $games
    ]);
  }
}
