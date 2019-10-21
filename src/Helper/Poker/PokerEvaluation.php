<?php
namespace App\Helper\Poker;

/* --------------------------------------------------------------
Contains method to e$valuate the strength of Poker hands

I made them as STATIC (class) methods, because they 
are like methods such as "sin(x)", "cos(x)", that
evaulate the sine, cosine of a $value x

Input of each method:

    array $h;  (5 Cards)

Output of each method:

    An integer $value represent the strength
    The higher the integer, the stronger the hand
-------------------------------------------------------------- */

class PokerEvaluation
{
    
    public const STRAIGHT_FLUSH = 8000000; 
                                            // + $valueHighCard()
    public const FOUR_OF_A_KIND = 7000000; 
                                            // + Quads Card Rank
    public const FULL_HOUSE     = 6000000; 
                                            // + SET card rank
    public const FLUSH          = 5000000;  
                                            // + $valueHighCard()
    public const STRAIGHT       = 4000000;   
                                            // + $valueHighCard()
    public const SET            = 3000000;    
                                            // + Set card $value
    public const TWO_PAIRS      = 2000000;     
                                            // + High2*14^4+ Low2*14^2 + card
    public const ONE_PAIR       = 1000000;      
                                            // + high*14^2 + high2*14^1 + low



    /***********************************************************
    Methods used to determine a certain Poker hand
    ***********************************************************/

    /* --------------------------------------------------------
        $valueHand(): return $value of a hand
        -------------------------------------------------------- */
    public static function valueHand( array $h ):int
    {
        if ( self::isFlush($h) && self::isStraight($h) )
            return self::valueStraightFlush($h);
        else if ( self::is4s($h) )
            return self::valueFourOfAKind($h);
        else if ( self::isFullHouse($h) )
            return self::valueFullHouse($h);
        else if ( self::isFlush($h) )
            return self::valueFlush($h);
        else if ( self::isStraight($h) )
            return self::valueStraight($h);
        else if ( self::is3s($h) )
            return self::valueSet($h);
        else if ( self::is22s($h) )
            return self::valueTwoPairs($h);
        else if ( self::is2s($h) )
            return self::valueOnePair($h);
        else
            return self::valueHighCard($h);
    }


    /* -----------------------------------------------------
        $valueFlush(): return $value of a Flush hand

            $value = FLUSH + $valueHighCard()
        ----------------------------------------------------- */
    public static function valueStraightFlush( array $h ):int
    {
        return self::STRAIGHT_FLUSH + self::valueHighCard($h);
    }

    /* -----------------------------------------------------
        $valueFlush(): return $value of a Flush hand

            $value = FLUSH + $valueHighCard()
        ----------------------------------------------------- */
    public static function valueFlush( array $h ):int
    {
        return self::FLUSH + self::valueHighCard($h);
    }

    /* -----------------------------------------------------
        $valueStraight(): return $value of a Straight hand

            $value = STRAIGHT + $valueHighCard()
        ----------------------------------------------------- */
    public static function valueStraight( array $h ):int
    {
        return self::STRAIGHT + self::valueHighCard($h);
    }

    /* ---------------------------------------------------------
        $valueFourOfAKind(): return $value of a 4 of a kind hand

            $value = FOUR_OF_A_KIND + 4sCardRank

        Trick: card $h[2] is always a card that is part of 
            the 4-of-a-kind hand
        There is ONLY ONE hand with a quads of a given rank.
        --------------------------------------------------------- */
    public static function valueFourOfAKind( array $h ):int
    {
        self::sortByRank($h);

        return self::FOUR_OF_A_KIND + $h[2]->rank();
    }

    /* -----------------------------------------------------------
        $valueFullHouse(): return $value of a Full House hand

            $value = FULL_HOUSE + SetCardRank

        Trick: card $h[2] is always a card that is part of
            the 3-of-a-kind in the full house hand
        There is ONLY ONE hand with a FH of a given set.
        ----------------------------------------------------------- */
    public static function valueFullHouse(array $h ):int
    {
        self::sortByRank($h);

        return self::FULL_HOUSE + $h[2]->rank();
    }

    /* ---------------------------------------------------------------
        $valueSet(): return $value of a Set hand

            $value = SET + SetCardRank

        Trick: card $h[2] is always a card that is part of the set hand
        There is ONLY ONE hand with a set of a given rank.
        --------------------------------------------------------------- */
    public static function valueSet( array $h ):int
    {
        self::sortByRank($h);
        return self::SET + $h[2]->rank();
    }

    /* -----------------------------------------------------
        $valueTwoPairs(): return $value of a Two-Pairs hand

            $value = TWO_PAIRS
                    + 14*14*HighPairCard
                    + 14*LowPairCard
                    + UnmatchedCard
        ----------------------------------------------------- */
    public static  function valueTwoPairs( array $h ):int
    {
        $val = 0;

        self::sortByRank($h);

        if ( $h[0]->rank() == $h[1]->rank() &&
            $h[2]->rank() == $h[3]->rank() )
        $val = 14*14*$h[2]->rank() + 14*$h[0]->rank() + $h[4]->rank();
        else if ( $h[0]->rank() == $h[1]->rank() &&
                $h[3]->rank() == $h[4]->rank() )
        $val = 14*14*$h[3]->rank() + 14*$h[0]->rank() + $h[2]->rank();
        else 
        $val = 14*14*$h[3]->rank() + 14*$h[1]->rank() + $h[0]->rank();

        return self::TWO_PAIRS + $val;
    }

    /* -----------------------------------------------------
        $valueOnePair(): return $value of a One-Pair hand

            $value = ONE_PAIR 
                    + 14^3*PairCard
                    + 14^2*HighestCard
                    + 14*MiddleCard
                    + LowestCard
        ----------------------------------------------------- */
    public static function valueOnePair( array $h ):int
    {
        $val = 0;

        self::sortByRank($h);

        if ( $h[0]->rank() == $h[1]->rank() )
        $val = 14*14*14*$h[0]->rank() +  
                + $h[2]->rank() + 14*$h[3]->rank() + 14*14*$h[4]->rank();
        else if ( $h[1]->rank() == $h[2]->rank() )
        $val = 14*14*14*$h[1]->rank() +  
                + $h[0]->rank() + 14*$h[3]->rank() + 14*14*$h[4]->rank();
        else if ( $h[2]->rank() == $h[3]->rank() )
        $val = 14*14*14*$h[2]->rank() +  
                + $h[0]->rank() + 14*$h[1]->rank() + 14*14*$h[4]->rank();
        else
        $val = 14*14*14*$h[3]->rank() +  
                + $h[0]->rank() + 14*$h[1]->rank() + 14*14*$h[2]->rank();

        return self::ONE_PAIR + $val;
    }

    /* -----------------------------------------------------
        $valueHighCard(): return $value of a high card hand

            $value =  14^4*highestCard 
                    + 14^3*2ndHighestCard
                    + 14^2*3rdHighestCard
                    + 14^1*4thHighestCard
                    + LowestCard
        ----------------------------------------------------- */
    public static function valueHighCard( array $h ):int
    {
        $val = 0;

        self::sortByRank($h);

        $val = $h[0]->rank() + 14* $h[1]->rank() + 14*14* $h[2]->rank() 
            + 14*14*14* $h[3]->rank() + 14*14*14*14* $h[4]->rank();

        return $val;
    }


    /***********************************************************
    Methods used to determine a certain Poker hand
    ***********************************************************/


    /* ---------------------------------------------
        is4s(): true if h has 4 of a kind
                false otherwise
        --------------------------------------------- */
    public static function is4s( array $h ):bool
    {
        $a1 = false;
        $a2 = false;

        if ( count($h) != 5 )
        return(false);

        self::sortByRank($h);

        $a1 = $h[0]->rank() == $h[1]->rank() &&
            $h[1]->rank() == $h[2]->rank() &&
            $h[2]->rank() == $h[3]->rank() ;

        $a2 = $h[1]->rank() == $h[2]->rank() &&
            $h[2]->rank() == $h[3]->rank() &&
            $h[3]->rank() == $h[4]->rank() ;

        return( $a1 || $a2 );
    }


    /* ----------------------------------------------------
        isFullHouse(): true if h has Full House
                    false otherwise
        ---------------------------------------------------- */
    public static function isFullHouse( array $h ):bool
    {
        $a1=false;
        $a2=false;

        if ( count($h) != 5 ){
            return(false);
        }

        self::sortByRank($h);

        $a1 = $h[0]->rank() == $h[1]->rank() &&  //  x x x y y
            $h[1]->rank() == $h[2]->rank() &&
            $h[3]->rank() == $h[4]->rank();

        $a2 = $h[0]->rank() == $h[1]->rank() &&  //  x x y y y
            $h[2]->rank() == $h[3]->rank() &&
            $h[3]->rank() == $h[4]->rank();

        return( $a1 || $a2 );
    }



    /* ----------------------------------------------------
        is3s(): true if h has 3 of a kind
                false otherwise

        **** Note: use is3s() ONLY if you know the hand
                does not have 4 of a kind 
        ---------------------------------------------------- */
    public static function is3s( array $h ):bool
    {
        $a1 = false; 
        $a2 = false; 
        $a3 = false;

        if ( count($h) != 5 )
        return(false);

        if ( self::is4s($h) || self::isFullHouse($h) )
        return(false);        // The hand is not 3 of a kind (but better)

        /* ----------------------------------------------------------
        Now we know the hand is not 4 of a kind or a full house !
        ---------------------------------------------------------- */
        self::sortByRank($h);

        $a1 = $h[0]->rank() == $h[1]->rank() &&
            $h[1]->rank() == $h[2]->rank() ;

        $a2 = $h[1]->rank() == $h[2]->rank() &&
            $h[2]->rank() == $h[3]->rank() ;

        $a3 = $h[2]->rank() == $h[3]->rank() &&
            $h[3]->rank() == $h[4]->rank() ;

        return( $a1 || $a2 || $a3 );
    }

    /* -----------------------------------------------------
        is22s(): true if h has 2 pairs
                false otherwise

        **** Note: use is22s() ONLY if you know the hand
                does not have 3 of a kind or better
        ----------------------------------------------------- */
    public static function is22s( array $h ):bool
    {
        $a1 = false; 
        $a2 = false;
        $a3 = false;

        if ( count($h) != 5 )
        return(false);

        if ( self::is4s($h) || self::isFullHouse($h) || self::is3s($h) )
        return(false);        // The hand is not 2 pairs (but better)

        self::sortByRank($h);

        $a1 = $h[0]->rank() == $h[1]->rank() &&
            $h[2]->rank() == $h[3]->rank() ;

        $a2 = $h[0]->rank() == $h[1]->rank() &&
            $h[3]->rank() == $h[4]->rank() ;

        $a3 = $h[1]->rank() == $h[2]->rank() &&
            $h[3]->rank() == $h[4]->rank() ;

        return( $a1 || $a2 || $a3 );
    }


    /* -----------------------------------------------------
        is2s(): true if h has one pair
                false otherwise

        **** Note: use is22s() ONLY if you know the hand
                does not have 2 pairs or better
        ----------------------------------------------------- */
    public static function is2s( array $h ):bool
    {
        $a1 = false; 
        $a2 = false;
        $a3 = false; 
        $a4 = false;

        if ( count($h) != 5 )
        return(false);

        if ( self::is4s($h) || self::isFullHouse($h) || self::is3s($h) || self::is22s($h) )
        return(false);        // The hand is not one pair (but better)

        self::sortByRank($h);

        $a1 = $h[0]->rank() == $h[1]->rank() ;
        $a2 = $h[1]->rank() == $h[2]->rank() ;
        $a3 = $h[2]->rank() == $h[3]->rank() ;
        $a4 = $h[3]->rank() == $h[4]->rank() ;

        return( $a1 || $a2 || $a3 || $a4 );
    }


    /* ---------------------------------------------
        isFlush(): true if h has a flush
                false otherwise
        --------------------------------------------- */
    public static function isFlush( array $h ):bool
    {
        if ( count($h) != 5 )
        return(false);

        self::sortBySuit($h);

        return( $h[0]->suit() == $h[4]->suit() );   // All cards has same suit
    }


    /* ---------------------------------------------
        isStraight(): true if h is a Straight
                    false otherwise
        --------------------------------------------- */
    public static function isStraight( array $h ):bool
    {
        $i = 0; 
        $testRank = 0;

        if ( count($h) != 5 )
        return(false);

        self::sortByRank($h);

        /* ===========================
        Check if hand has an Ace
        =========================== */
        if ( $h[4]->rank() == 14 )
        {
            /* =================================
                Check straight using an Ace
                ================================= */
            $a = $h[0]->rank() == 2 && $h[1]->rank() == 3 &&
                        $h[2]->rank() == 4 && $h[3]->rank() == 5 ;
            $b = $h[0]->rank() == 10 && $h[1]->rank() == 11 &&
                        $h[2]->rank() == 12 && $h[3]->rank() == 13 ;

            return ( $a || $b );
        }
        else
        {
            /* ===========================================
                General case: check for increasing $values
                =========================================== */
            $testRank = $h[0]->rank() + 1;

            for ( $i = 1; $i < 5; $i++ )
            {
                if ( $h[$i]->rank() != $testRank )
                    return(false);        // Straight failed...

                $testRank++;
            }

            return(true);        // Straight found !
        }
    }

    /* ===========================================================
        Helper methods
        =========================================================== */

    /* ---------------------------------------------
        Sort hand by rank:

            smallest ranked card first .... 

        (Finding a straight is eaiser that way)
        --------------------------------------------- */
    public static function sortByRank( array &$h ):void
    {
        $i = 0;
        $j = 0;
        $min_j = 0;

        /* ---------------------------------------------------
        The selection sort algorithm
        --------------------------------------------------- */
        for ( $i = 0 ; $i < count($h) ; $i ++ )
        {
            /* ---------------------------------------------------
                Find array element with min. $value among
                $h[i], $h[i+1], ..., $h[n-1]
                --------------------------------------------------- */
            $min_j = $i;   // Assume elem i ($h[i]) is the minimum

            for ( $j = $i+1 ; $j < count($h) ; $j++ )
            {
                if ( $h[$j]->rank() < $h[$min_j]->rank() )
                {
                    $min_j = $j;    // We found a smaller minimum, update min_j     
                }
            }

            /* ---------------------------------------------------
                Swap a[i] and a[$min_j]
                --------------------------------------------------- */
            $help = $h[$i];
            $h[$i] = $h[$min_j];
            $h[$min_j] = $help;
        }
    }

    /* ---------------------------------------------
        Sort hand by suit:

            smallest suit card first .... 

        (Finding a flush is eaiser that way)
        --------------------------------------------- */
    public static function sortBySuit( array &$h ):void
    {
        $i = 0; 
        $j = 0;
        $min_j = 0;

        /* ---------------------------------------------------
        The selection sort algorithm
        --------------------------------------------------- */
        for ( $i = 0 ; $i < count($h) ; $i ++ )
        {
            /* ---------------------------------------------------
            Find array element with min. $value among
            $h[i], $h[i+1], ..., $h[n-1]
            --------------------------------------------------- */
            $min_j = $i;   // Assume elem i ($h[i]) is the minimum

            for ( $j = $i+1 ; $j < count($h) ; $j++ )
            {
                if ( $h[$j]->suit() < $h[$min_j]->suit() )
                {
                    $min_j = $j;    // We found a smaller minimum, update min_j     
                }
            }

            /* ---------------------------------------------------
                Swap a[i] and a[$min_j]
            --------------------------------------------------- */
            $help = $h[$i];
            $h[$i] = $h[$min_j];
            $h[$min_j] = $help;
        }
    }

}