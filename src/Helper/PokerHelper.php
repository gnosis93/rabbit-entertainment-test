<?php

namespace App\Helper;

use App\Entity\Hand as DBHand;
use App\Helper\Poker\Card;
use App\Helper\Poker\PokerEvaluation;
use RuntimeException;

class PokerHelper{

    private const CARD_TYPES = [
        'D' => 1,
        'C' => 2,
        'H' => 3,
        'S' => 4,
    ];

    public static function getWinner(DBHand $handInDb){
        $playerOneHand = self::getHandOfCards($handInDb->getPlayerOneHandArray());
        
        $playerOneHandValue = PokerEvaluation::valueHand($playerOneHand);
        
        $playerTwoHand = self::getHandOfCards($handInDb->getPlayerTwoHandArray());
        $playerTwoHandValue = PokerEvaluation::valueHand($playerTwoHand);
        
        if($playerOneHandValue > $playerTwoHandValue){
            $msg = "Player One";
        }else{
            $msg = "Player Two";
        }
        
        
        return $msg;
    }


    private static function getHandOfCards(array $playerHand):array{
        $cards = [];
        foreach($playerHand as $cardCode){
            $pokerCard = self::cardCodeToCard($cardCode);
            if(!$pokerCard){
                throw new RuntimeException('Invalid Card');
            }
            $cards[] = $pokerCard;
        }

        if(count($cards) !== 5){
            throw new RuntimeException('Invalid Number of cards for player hand: '.implode(',',$playerHand));
        }
        return $cards;
    }

    private static function cardCodeToCard(string $cardCode):Card{
        if(strlen($cardCode) !== 2){
            throw new RuntimeException("Invalid Card Code Given: $cardCode");
        }
        
        $cardNumber = $cardCode[0];
        $cardType   = $cardCode[1];

        $validCardType = isset(self::CARD_TYPES[$cardType]);
        if($validCardType === false){
            throw new RuntimeException("Invalid Card Code Given: $cardCode");
        }

        
        if(is_string($cardNumber) && strtoupper($cardNumber) === 'T'){
            $cardNumber = 10;
        }else if(is_string($cardNumber) && strtoupper($cardNumber) === 'J'){
            $cardNumber = 11;
        }else if(is_string($cardNumber) && strtoupper($cardNumber) === 'Q'){
            $cardNumber = 12;
        }else if(is_string($cardNumber) && strtoupper($cardNumber) === 'K'){
            $cardNumber = 13;
        }else if(is_string($cardNumber) && strtoupper($cardNumber) === 'A'){
            $cardNumber = 14;
        }

        if(is_numeric($cardNumber) === false){
            throw new RuntimeException("Invalid Card Code Given: $cardCode");
            
        }

        return new Card(self::CARD_TYPES[strtoupper($cardType)],(int)$cardNumber);
    }

}