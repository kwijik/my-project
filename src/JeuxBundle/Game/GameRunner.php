<?php

namespace JeuxBundle\Game;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameRunner {

    /**
     * The Game context.
     *
     * @var GameContextInterface
     */
    private $context;

    /**
     * The list of words.
     *
     * @var WordListInterface
     */
    private $wordList;

    /**
     * Constructor.
     *
     * @param GameContextInterface $context
     * @param WordListInterface    $wordList
     */
    public function __construct(
    GameContextInterface $context, WordListInterface $wordList = null
    ) {
        $this->context = $context;
        $this->wordList = $wordList;
    }

    /**
     * Loads the current game or creates a new one.
     *
     * @param int $length The word length to guess
     *
     * @return Game
     */
    public function loadGame($length = 8) {



        if ($game = $this->context->loadGame()) {
            dump($game);
            //    die();
            return $game;
        }

        if (!$this->wordList) {
            throw new \RuntimeException('A WordListInterface instance must be set.');
        }

        $word = $this->wordList->getRandomWord($length);
        dump($word);
        //die();
        $game = $this->context->newGame($word);
        $this->context->save($game);

        return $game;
    }

    public function resetGame(\Closure $onStatusCallback = null) {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        // Custom logic on failure or on success
        // thanks to an anonymous function
        if ($onStatusCallback) {
            call_user_func_array($onStatusCallback, [ $game]);
        }

        $this->context->reset();
        return $game;
    }

    /**
     * Tests the given letter against the current game.
     *
     * @param string $letter An alpha character from "a" to "z"
     *
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playLetter($letter) {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        $game->tryLetter($letter);
        $this->context->save($game);

        return $game;
    }
    
        /**
     * Tests the given word against the current game.
     *
     * @param string $word
     *
     * @return Game
     * @throws NotFoundHttpException
     */
    public function playWord($word)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context set.');
        }

        $game->tryWord($word);
        $this->context->save($game);

        return $game;
    }

}
