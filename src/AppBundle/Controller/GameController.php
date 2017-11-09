<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameRunner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('game/index.html.twig', [
            'game' => $this->get(GameRunner::class)->loadGame(),
        ]);
    }

    /**
     * @Route("/game/letter/{letter}", name="game_play_letter")
     * @Method("GET")
     */
    public function playLetterAction($letter)
    {
        $this->get(GameRunner::class)->playLetter($letter);

        return $this->redirectToRoute('game_index');
    }

    /**
     * @Route("/game/word", name="game_play_word", condition="request.request.has('word')")
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $game = $this->get(GameRunner::class)->playWord($request->request->getAlpha('word'));

        if ($game->isWon()) {
            return $this->redirectToRoute('game_won');
        }

        return $this->redirectToRoute('game_failed');
    }

    /**
     * @Route("/game/won", name="game_won")
     * @Method("GET")
     */
    public function wonAction()
    {
        return $this->render('game/won.html.twig', [
            'game' => $this->get(GameRunner::class)->resetGameOnSuccess(),
        ]);
    }

    /**
     * @Route("/game/failed", name="game_failed")
     * @Method("GET")
     */
    public function failedAction()
    {
        return $this->render('game/failed.html.twig', [
            'game' => $this->get(GameRunner::class)->resetGameOnFailure(),
        ]);
    }

    /**
     * @Route("/game/reset", name="game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->get(GameRunner::class)->resetGame();

        return $this->redirectToRoute('game_index');
    }
}
