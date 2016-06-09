<?php

require_once 'StealTheDeckCardGame.class.php';

$Game = New Deirde\StealTheDeckCardGame\Game();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/assets/main.css">
    </head>
    <body>
        <div class="row">
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/">
                                <?php echo $Game->pageTitle(); ?>
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="col-md-12">
                    <form method="POST">
                        
                        <?php if ($Game->getData('gameOver')) { ?>
                        
                            <div class="jumbotron">
                                <h1>
                                    <?php echo sprintf('The winner is the player %s',
                                        $Game->getData('gameOver')); ?>
                                </h1>
                                <p>
                                    <input type="submit" class="btn btn-lg btn-danger" value="restart" name="action">
                                </p>
                            </div>
                        
                        <?php } else { ?>
                        
                            <?php if (!isset($_SESSION[$Game->_()])) { ?>
                                
                                <p>
                                    <?php echo _('Here are the rules of the game') . ':'; ?><br/>
                                    <ul>
                                        <li>
                                            <?php echo _('Two players are dealt the same number of cards from a shuffled deck.'); ?>
                                        </li>
                                        <li>
                                            <?php echo _('Each player takes it in turns to place their next card on a pile between them.'); ?>
                                        </li>
                                        <li>
                                            <?php echo _('If the two top cards on the pile match in numeric value (e.g. 9 == 9), the last player to place a card takes all the cards in the pile.'); ?>
                                        </li>
                                        <li>
                                            <?php echo _('The game continues until one player is out of cards.'); ?>
                                        </li>
                                    </ul>
                                </p>
                                <input type="submit" class="btn btn-lg btn-info" value="begin" name="action">
                            
                            <?php } else { ?>
                            
                                <?php for ($i = 1; $i <= 2; $i++) { ?>
                                    <ul class="items-wrapper panel panel-warning">
                                        <h3 class="panel-title">
                                            <?php echo sprintf('Player %s', $i); ?>
                                            <?php if ($Game->getData('currPlayer') == $i) { ?>
                                                <small>
                                                    <?php echo _('The current player'); ?>
                                                </small>
                                            <?php } ?>
                                        </h3>
                                        <?php foreach ($Game->getData('deckPlayer' . $i) as $card) { ?>
                                            <li>
                                                <span>
                                                    <?php echo $card; ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                                
                                <ul class="items-wrapper panel panel-success">
                                    <h3 class="panel-title">
                                        <?php echo _('Cards on table'); ?>
                                    </h3>
                                    <?php
                                    if ($deckOnTable = $Game->getData('deckOnTable')) {
                                        foreach ($Game->getData('deckOnTable') as $card) {
                                        ?>
                                            <li>
                                                <span>
                                                    <?php echo $card; ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                                
                                <input type="submit" class="btn btn-lg btn-success" value="next-turn" name="action">
                                <input type="submit" class="btn btn-lg btn-danger btn-right" value="restart" name="action">
                            
                            <?php } ?>
                            
                        <?php } ?>
                    
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>