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
                        
                            <?php if (empty($Game->_())) { ?>
                            
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