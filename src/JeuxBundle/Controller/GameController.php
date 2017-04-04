<?php
namespace JeuxBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
* @Route("/game") */
class GameController extends Controller { 

	/**
	* @Route("/", name="game_page")
	*/
	public function homeAction() {
		return $this->render('game/home.html.twig'); 
	}



	/**
	* @Route("/won", name="won")
	*/
	public function gameWonAction() {
		return $this->render('game/won.html.twig'); 
	}

	/**
	* @Route("/reset", name="reset")
	*/
	public function resetGameAction() {
		return $this->render('game/home.html.twig'); 
	}

	/**
	* @Route("/failed", name="game_failed")
	*/
	public function gameFailedAction() {
		return $this->render('game/failed.html.twig'); 
	}
}



