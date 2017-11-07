<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game_index")
     */
    public function indexAction()
    {
        return $this->render('game/index.html.twig');
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
