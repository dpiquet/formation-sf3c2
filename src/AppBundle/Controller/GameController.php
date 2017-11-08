<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameContext;
use AppBundle\Game\GameRunner;
use AppBundle\Game\Loader\TextFileLoader;
use AppBundle\Game\Loader\XmlFileLoader;
use AppBundle\Game\WordList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('game/index.html.twig', [
            'game' => $this->getRunner($request->getSession())->loadGame(),
        ]);
    }

    /**
     * @Route("/game/letter/{letter}", name="game_play_letter")
     */
    public function playLetterAction(Request $request, $letter)
    {
        $this->getRunner($request->getSession())->playLetter($letter);

        return $this->redirectToRoute('game_index');
    }

    /**
     * @Route("/game/word", name="game_play_word", condition="request.request.has('word')")
     */
    public function playWordAction(Request $request)
    {
        $game = $this->getRunner($request->getSession())
            ->playWord($request->request->getAlpha('word'))
        ;

        if ($game->isWon()) {
            return $this->redirectToRoute('game_won');
        }

        return $this->redirectToRoute('game_failed');
    }

    /**
     * @Route("/game/won", name="game_won")
     */
    public function wonAction(Session $session)
    {
        $this->getRunner($session)->resetGameOnSuccess();

        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/game/failed", name="game_failed")
     */
    public function failedAction(Session $session)
    {
        $this->getRunner($session)->resetGameOnFailure();

        return $this->render('game/failed.html.twig');
    }

    /**
     * @Route("/game/reset", name="game_reset")
     */
    public function resetAction(Session $session)
    {
        $this->getRunner($session)->resetGame();

        return $this->redirectToRoute('game_index');
    }

    private function getRunner(SessionInterface $session): GameRunner
    {
        $wordList = new WordList();
        $wordList->addLoader('txt', new TextFileLoader());
        $wordList->addLoader('xml', new XmlFileLoader());
        $wordList->loadDictionaries([
            __DIR__.'/../../../app/Resources/data/test.txt',
            __DIR__.'/../../../app/Resources/data/words.txt',
            __DIR__.'/../../../app/Resources/data/words.xml',
        ]);

        return new GameRunner(new GameContext($session), $wordList);
    }
}
