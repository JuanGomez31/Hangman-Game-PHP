<?php

class Word {

    private String $word;

    public function __construct() {
        $this->word = strtolower($this->getRandomWord());
    }

    public function getWord(): String {
        return $this->word;
    }

    public function getWordLenght(): int {
        return strlen($this->word);
    }

    public function hasLetter(String $letter) : bool {
        return str_contains($this->word, $letter);
    }

    public function save(): void {
        $_SESSION['word'] = serialize($this);
    }

    private function getRandomWord(): String {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://random-word-api.herokuapp.com/word');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        return $data[0];
    }

}