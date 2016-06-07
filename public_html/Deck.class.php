<?php

/**
 * Contains methods for interacting with a deck of cards.
 * 
 * @author Daniel Sposito <daniel.g.sposito@gmail.com>
 */
class Deck
{
    /**
     * Builds a deck of cards.
     * @return array
     */
    public static function cards()
    {
        
        $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');
        $suits  = array('S', 'H', 'D', 'C');
        
        $cards = array();
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $cards[] = $value . $suit;
            }
        }
        
        return $cards;
        
    }
    
    /**
     * Shuffles an array of cards.
     * @param array $cards The array of cards to shuffle.
     * @return array
     */
    public static function shuffle(array $cards)
    {
        
        $total_cards = count($cards);
        
        foreach ($cards as $index => $card) {
            
            // Pick a random second card.
            $card2_index = mt_rand(1, $total_cards) - 1;
            $card2 = $cards[$card2_index];
            
            // Swap the positions of the two cards.
            $cards[$index] = $card2;
            $cards[$card2_index] = $card;
        }
        
        return $cards;
    }
    
    /**
     * Splits the deck.
     */
    public static function split($players = 2) {
        
        $cards = self::shuffle(self::cards());
        
        return array_chunk($cards, intval(ceil(sizeof($cards) / $players)));
        
    }
    
    /**
     * Picks the first card from the deck.
     */
    public function pickTheCard($deck) {
        
        return reset($deck);
        
    }
    
    /**
     *
     */
    public function isTheTurnOf() {
    }
    
    /**
     *
     */
    public function cardValue($card) {
    }
    
    
    
    
}

?>