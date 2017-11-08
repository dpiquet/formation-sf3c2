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

class GameController extends Controller
{
    /**
     * @Route("/game", name="game_index")
     */
    public function indexAction(Request $request)
    {
        $wordList = new WordList();
        $wordList->addLoader('txt', new TextFileLoader());
        $wordList->addLoader('xml', new XmlFileLoader());
        $wordList->loadDictionaries([
            __DIR__.'/../../../app/Resources/data/test.txt',
            __DIR__.'/../../../app/Resources/data/words.txt',
            __DIR__.'/../../../app/Resources/data/words.xml',
        ]);

        $runner = new GameRunner(new GameContext($request->getSession()), $wordList);

        return $this->render('game/index.html.twig', [
            'game' => $runner->loadGame(),
        ]);
    }

    /**
     * @Route("/game/won", name="game_won")
     */
    public function wonAction()
    {
        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/game/failed", name="game_failed")
     */
    public function failedAction()
    {
        return $this->render('game/failed.html.twig');
    }
}
