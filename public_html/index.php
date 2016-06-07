<?php

require_once 'Deck.class.php';

?>

<?php if (isset($_GET['submit']) && $_GET['submit'] == 'pick-a-card' && 
    count($_SESSION[$_][$_SESSION[$_]['turn_of']]['deck']) == 0) { ?>

    <b>
        <?php echo $_SESSION[$_]['turn_of'] . ' WIN!'; ?>
    </b>

    <form method="GET">
        <input type="submit" value="restart-game" name="submit">
    </form>
    
    <?php exit(); ?>
    
<?php } ?>

<?php if (isset($_SESSION[$_]) 
    && $_SESSION[$_]['in_progress'] == true) { ?>
    
    <?php for ($i = 1; $i <= 2; $i++) { ?>
        <hr />
        <?php echo 'PLAYER' . ' ' . $i; ?>
        <?php foreach ($_SESSION[$_]['player_' . $i]['deck'] as $card) { ?>
            <?php echo $card; ?>
        <?php } ?>
    <?php } ?>
    <hr/>
    CARDS ON TABLE:
    <?php if (isset($_SESSION[$_]['cards_on_table'])) { ?>
        <?php foreach ($_SESSION[$_]['cards_on_table'] as $card) { ?>
            <?php echo $card; ?>
        <?php } ?>
    <?php } ?>
    
    <hr/>
    Is the turn of: <?php echo $_SESSION[$_]['turn_of']; ?>
    
    <form method="GET">
        <input type="submit" value="pick-a-card" name="submit">
        <input type="submit" value="restart-game" name="submit">
    </form>

<?php } else { ?>

    <form method="GET">
        <input type="submit" value="start-the-game" name="submit">
    </form>

<?php } ?>