<?php
    include_once 'models/Word.php';
    include_once 'models/Player.php';
    session_start();

    if(isset($_SESSION['player'])) {
        $word  = unserialize($_SESSION['word']);
        $player = unserialize($_SESSION['player']);
    } else {
        $word = new Word();
        $word->save();
        $player = new Player($word);
        $_SESSION['player'] = serialize($player);
    }

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <title>Hangman</title>
    </head>
    <body>
        <header>
            <h1>Hangman Game</h1>
            <h3>PHP Hangman game</h3>
        </header>
        <main>
            <div class="game-info">
                <h4>Lives: <?= Player::MAX_ATTEMPTS - $player->getAttempts() ?></h4>
            </div>
            <div class="img-container">
                <img src="<?= $player->getPlayerPicture()?>" alt="Hangman Picture">
            </div>
            <?php if($player->hasLost()): ?>
            <div class="game-data">
                <h5 class="discovered-letters">Has perdido</h5>
                <form method="post" action="logic/comprobante.php">
                    <input type="submit" value="Volver a jugar">
                </form>
            </div>
            <?php elseif($player->hasWin($word)): ?>
                <div class="game-data">
                    <h5 class="discovered-letters">Has Ganado</h5>
                    <form method="post" action="logic/comprobante.php">
                        <input type="submit" value="Volver a jugar">
                    </form>
                </div>
            <?php else: ?>
            <div class="game-data">
                <h5 class="discovered-letters"><?= $player->getDiscoveredLetters() ?></h5>
                <form method="post" action="logic/comprobante.php">
                    <input name="letra" type="text" minlength="1" maxlength="1" required>
                    <input type="submit" value="Comprobar">
                </form>
            </div>
            <?php endif; ?>
            <div class="used-letters">
                <h3>Used letters</h3>
                <ul>
                    <?php foreach ($player->getLettersUsed() as $letter): ?>
                        <li><?= $letter ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </body>
</html>
