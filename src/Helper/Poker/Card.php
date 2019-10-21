<?php
namespace App\Helper\Poker;

class Card
{    
    const Suit = ["*", "d", "c", "h", "s"];
    const Rank = [ "*", "*", "2", "3", "4","5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];    

    /**
     * @var int
     */
    private $cardSuit;
    
    /**
     * @var int
     */
    private $cardRank;


    /* ----------------------------------------------------------------
        Constructor
        Example usage:

            Card x = new Card( Card.SPADE, 1 );    // Ace of Spade
        Card x = new Card( Card.HEART, 11 );   // Jack of Heart
        --------------------------------------------------------------- */
        public function __construct( int $suit, int $rank )
        {
            if ( $rank == 1 ) // (Ace) 
                $this->cardRank = 14; // Give Ace the rank 14
            else
                $this->cardRank =  $rank;
            
            $this->cardSuit = (int) $suit;
        }

        public function suit()
        {
          return $this->cardSuit;        
                                    
        }
  
        public function suitStr():string
        {
          return self::Suit[ $this->cardSuit ] ; 
        }
      
        public  function rank():int
        {
          return $this->cardRank;
        }
  
        public function rankStr():string
        {
           return  self::Rank[$this->cardRank];
        }
}