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
    public function index(Request $request, PaginatorInterface $paginator)

    {
        $games = $this->getDoctrine()
        ->getRepository(Game::class)
        ->findBy([],['name' => 'ASC']);

          $gamesList = $paginator->paginate(
          $games, // Requête contenant les données à paginer (ici nos articles)
          $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
          10 // Nombre de résultats par page
      );

        return $this->render('game/index.html.twig', [
            'gamesList' => $gamesList,
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
