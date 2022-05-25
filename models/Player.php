<?php

class Player {
    public const MAX_ATTEMPTS = 6;
    private static $PLAYER_PICTURES = ['./assets/hangman_6.png', "./assets/hangman_5.png", "./assets/hangman_4.png",
        "./assets/hangman_3.png", "./assets/hangman_2.png", "./assets/hangman_1.png", "./assets/hangman_0.png"];
    private String $discoveredLetters;
    private int $attempts;
    private Array $lettersUsed = [];

    public function __construct(Word $word) {
        $this->discoveredLetters = str_pad("", $word->getWordLenght(), "_");
        $this->attempts = 0;
    }

    public function getAttempts(): int {
        return $this->attempts;
    }

    public function getPlayerPicture(): String {
        return Player::$PLAYER_PICTURES[$this->attempts];
    }

    public function getDiscoveredLetters(): String {
        return $this->discoveredLetters;
    }

    public function addLetterToList(String $letter): void {
        array_push($this->lettersUsed, $letter);
    }

    public function letterHaveBeenProveed(String $letter) : bool {
        return in_array($letter, $this->lettersUsed);
    }

    public function removeLives(): void {
        $this->attempts++;
    }

    public function hasLost(): bool {
        return $this->attempts == self::MAX_ATTEMPTS;
    }

    public function hasWin(Word $word): bool {
        return $word->getWord() == $this->discoveredLetters;
    }

    public function revealLetter(String $letter, Word $word) : void {
        $offset = 0;
        while(($letterPosition = strpos($word->getWord(), $letter, $offset)) !== false) {
            $this->discoveredLetters[$letterPosition] = $letter;
            $offset = $letterPosition + 1;
        }
    }

    public function getLettersUsed(): Array {
        return $this->lettersUsed;
    }

    public function save(): void {
        $_SESSION['player'] = serialize($this);
    }


}