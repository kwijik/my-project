<?php

namespace JeuxBundle\Game;



class WordList implements  WordListInterface {

    private $words;
    private $loaders;

    public function __construct() {
        $this->words = array();
        $this->loaders = array();
    }
    

    public function loadDictionary($words) {
        foreach ($words as $i => $word) {
            $this->addWord($word->getWords());
        }
    }

    public function getRandomWord($length) {
        //dump($length);
        if (!isset($this->words[$length])) {
            throw new \InvalidArgumentException(sprintf('There is no word of length %u.', $length));
        }

        $key = array_rand($this->words[$length]);
        dump($key);
        dump($this->words[$length][$key]);
        return $this->words[$length][$key];
    }

    public function addWord($word) {
        $length = strlen($word);
        dump($length);
        //die();
        if (!isset($this->words[$length])) {
            $this->words[$length] = array();
        }

        if (!in_array($word, $this->words[$length])) {
            $this->words[$length][] = $word;
            //dump($this->words[$length]);
        }
    }

}
