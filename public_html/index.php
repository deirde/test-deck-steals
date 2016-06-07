<?php

require_once 'Deck.class.php';
$_ = 'deck-steals-game';
$deck = New Deck();
    
if (session_status() == PHP_SESSION_NONE)
{
    
    session_start();
    
}

if (isset($_GET['submit']) && $_GET['submit'] == 'restart-game')
{
    
    unset($_SESSION[$_]);
    
}

if (isset($_GET['submit']) && $_GET['submit'] == 'start-the-game')
{
    
    $_SESSION[$_] = $deck->setupTheGame();
    
}

if (isset($_GET['submit']) && $_GET['submit'] == 'pick-a-card') {
 
    $_SESSION[$_]['turn_of'] = (($_SESSION[$_]['turn_of'] == 'player_1') ? 'player_2' : 'player_1');
    
    $picked_card = $deck::pickTheCard($_SESSION[$_][$_SESSION[$_]['turn_of']]['deck']);
    $this_card_value = substr($picked_card, 0, 1);
    
    if ($_SESSION[$_]['cards_on_table']) {
        
        $last_card_value = end($_SESSION[$_]['cards_on_table']);
        $last_card_value = substr($last_card_value, 0, 1);
        
        if ($this_card_value == $last_card_value) {
            
            $_SESSION[$_][$_SESSION[$_]['turn_of']]['deck'] =  array_merge(
                $_SESSION[$_][$_SESSION[$_]['turn_of']]['deck'], 
                $_SESSION[$_]['cards_on_table']);
            
            unset($_SESSION[$_]['cards_on_table']);
            
        }
        
    }
    
    $_SESSION[$_]['cards_on_table'][] = $picked_card;
    
    array_shift($_SESSION[$_][$_SESSION[$_]['turn_of']]['deck']);
    
}

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