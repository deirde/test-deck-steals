<?php

namespace Deirde\DeckSteals {
    
    /**
     * Opens the session.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    class Game
    {
        
        /**
         * Triggers the methods basing on the action parameter.
         */
        public function __construct()
        {
            
            // Defines the curr action.
            $action = ((isset($_POST['action'])) ? $_POST['action'] : false);
            
            if ($action == 'begin' || $action == 'restart') {
                
                // Starts a new game.
                $this->begin();
                
            } elseif ($action == 'next-turn') {
                
                // The next turn processes.
                $this->process($this->getData('currPlayer'));
                
                // Defines the curr player.
                $this->currPlayer();
                
            }
            
            // Checks if one player is out of cards.
            $this->gameOver();
            
        }
        
        /**
         * Returns the page title.
         */
        public function pageTitle() {
            
            return _(get_class($this));
            
        }
        
        /**
         * Defines the session storage name.
         */
        public function _()
        {
            
            return get_class($this);
            
        }
        
        /**
         * Gets data from the session storage.
         */
        public function getData($key) {
            
            $response = $_SESSION[$this->_()];
            
            if (isset($response[$key])) {
                return $response[$key];
            } else {
                return null;
            }
            
        }
        
        /**
         * Sets data from the session storage.
         */
        public function setData($key, $value)
        {
            
            $_SESSION[$this->_()][$key] = $value;
            
        }
        
        /**
         * Unsets a key from the session storage.
         */
        public function unsetData($key)
        {
            
            $data = $_SESSION[$this->_()];
            
            if (isset($data[$key])) {
                unset($data[$key]);
            }
            
            return $_SESSION[$this->_()] = $data;
            
        }
        
        /**
         * Resets the session storage.
         */
        public function resetData()
        {
            
            unset($_SESSION[$this->_()]);
            
        }
        
        /**
         * Creates the cards for a deck.
         */
        private function createCards()
        {
            
            $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');
            $suits  = array('S', 'H', 'D', 'C');
            
            $response = array();
            foreach ($suits as $suit) {
                foreach ($values as $value) {
                    $response[] = $value . $suit;
                }
            }
            
            return $response;
            
        }
        
        /**
         * Shuffles the deck cards.
         */
        private function shuffleCards(array $cards)
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
         * Splits the cards between the players.
         */
        private function splitCards()
        {
            
            //$cards = $this->shuffleCards($this->createCards());
            $cards = $this->createCards();
            shuffle($cards);
            
            return array_chunk($cards, intval(ceil(sizeof($cards) / 2)));
            
        }
        
        /**
         * Bootstraps the game.
         */
        private function begin()
        {
            
            $this->resetData();
            
            $splitCards = $this->splitCards();
            
            $this->setData('deckPlayer1', $splitCards[0]);
            $this->setData('deckPlayer2', $splitCards[1]);
            $this->setData('deckOnTable', []);
            $this->setData('currPlayer', rand(1, 2));
            
        }
        
        /**
         * Define the next turn player.
         */
        private function alternatePlayer($currPlayer)
        {
            
            $response = (($currPlayer == 1) ? 2 : 1);
            $this->setData('currPlayer', $response);
            
        }
        
        /**
         * Defines the curr turn player.
         */
        private function currPlayer() {
            
            $this->alternatePlayer($this->getData('currPlayer'));
            
        }
        
        private function process($currPlayer)
        {
            
            // The last card of the deck on the table.
            $prevCardVal = false;
            if ($this->getData('deckOnTable')) {
                $prevCard = end($this->getData('deckOnTable'));
                $prevCardVal = $this->getTheCardVal($prevCard);
            }
            
            // The last player card on the table.
            $currPlayerDock = $this->getData('deckPlayer' . $currPlayer);
            $currCard = $this->getTheFirstDeckCard($currPlayerDock);
            $currCardVal = $this->getTheCardVal($currCard);
            
            // Removes the card just played from the player deck.
            array_shift($currPlayerDock);
            $this->setData('deckPlayer' . $currPlayer, $currPlayerDock);
            
            // Adds the player card into the deck on table
            $deckOnTable = $this->getData('deckOnTable');
            $deckOnTable[] = $currCard;
            $this->setData('deckOnTable', $deckOnTable);
            
            // Checks the match.
            $this->thePlayerTakesTheDeckOnTable($currPlayer, $prevCardVal, $currCardVal);
            
        }
        
        /**
         * We've the match.
         */
        private function thePlayerTakesTheDeckOnTable($currPlayer, $prevCardVal, $currCardVal) {
            
            
            if ($prevCardVal == $currCardVal) {
                
                // New player deck.
                $currPlayerDock = array_merge($this->getData('deckPlayer' . $currPlayer), $this->getData('deckOnTable'));
                $this->setData('deckPlayer' . $currPlayer, $currPlayerDock);
                
                // Clean the deck on table.
                $this->unsetData('deckOnTable');
                
            }
            
        }
        
        /**
         * Gets the numeric value of the given card.
         */
        private function getTheCardVal($card)
        {
            
            return substr($card, 0, 1);
            
        }
        
        /**
         * Gets the first card of the deck.
         */
        private function getTheFirstDeckCard($deck)
        {
            
            return reset($deck);
            
        }
        
        /**
         * Gets the numeric value of the first card on the deck.
         */
        private function getTheFirstDeckCardVal($deck)
        {
            
            return $this->getTheCardVal($this->getTheFirstDeckCard($deck));
            
        }
        
        /**
         * If a player has no cards left it triggers the end of the game.
         */
        private function gameOver()
        {
            
            for ($i = 1; $i <= 2; $i++) {
                
                if (empty($this->getData('deckPlayer' . $i))) {
                    
                    $this->setData('gameOver', (($i == 1) ? 2 : 1));
                    
                }
                
            }
            
        }
        
    }
    
}

?>