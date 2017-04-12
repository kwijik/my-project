<?php

namespace JeuxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WordList
 *
 * @ORM\Table(name="word_list")
 * @ORM\Entity(repositoryClass="JeuxBundle\Repository\WordListRepository")
 */
class WordList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="words", type="string", length=255)
     */
    private $words;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set words
     *
     * @param string $words
     *
     * @return WordList
     */
    public function setWords($words)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Get words
     *
     * @return string
     */
    public function getWords()
    {
        return $this->words;
    }
}

