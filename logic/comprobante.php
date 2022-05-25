<?php

    include_once '../models/Word.php';
    include_once '../models/Player.php';
    session_start();

    function comprobateLetter(Word $word, Player $player, String $letter): void {
        if($word->hasLetter($letter)) {
            $player->revealLetter($letter, $word);
        } else if(!$player->letterHaveBeenProveed($letter)) {
            $player->addLetterToList($letter);
            $player->removeLives();
        }
        $player->save();
    }

    function redirectToMainWeb(): void {
        header("Location: /", TRUE, 301);
    }

    if (isset($_SESSION['player']) && isset($_POST['letra'])) {
        $word = unserialize($_SESSION['word']);
        $player = unserialize($_SESSION['player']);
        $letter = strtolower(substr($_POST["letra"], 0, 1));
        if(!(strlen($letter) < 1)) {
            comprobateLetter($word, $player, $letter);
        }
    } else if(!isset($_POST['letra'])) {
        session_destroy();
    }

    redirectToMainWeb();