<?php

namespace JeuxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JeuxBundle\Entity\WordList;

/**
 * @Route("/game", requirements={
 *      "_locale": "fr|en"
 * })
 */
class GameController extends Controller {

    /**
     * @Route("/failed", name="game_failed")
     */
    public function gameFailedAction() {

        return $this->render('game/failed.html.twig');
    }

    /**
     * @Route("/won", name="game_won")
     */
    public function gameWonAction() {
        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/", name="game")
     */
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $wordsList = $em->getRepository("JeuxBundle:WordList")->findAll();
        $this->get('app.word_list')->loadDictionary($wordsList);

        return $this->render('game/home.html.twig', [
                    'game' => $this->get('app.game_runner')->loadGame($this->getParameter('word_length')),
        ]);
    }

    /**
     * @Route("/reset", name="game_reset")
     */
    public function resetGameAction() {
        $this->get('app.game_runner')->resetGame();

        return $this->redirectToRoute('game');
    }

    /**
     * @Route("/play/letter/{letter}", name="game_play_letter", requirements={
     *      "letter": "[A-Z]"
     * })
     * @Method("GET")
     */
    public function playLetterAction($letter) {
        $game = $this->get('app.game_runner')->playLetter($letter);

        if (!$game->isOver()) {
            return $this->redirectToRoute('game');
        }

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
    }

    /**
     * @Route("/play", name="game_play_word", condition="request.request.has('word')")
     * @Method("POST")
     */
    public function playWordAction(Request $request) {
        $game = $this->get('app.game_runner')->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
    }

}
