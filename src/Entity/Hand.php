<?php
// src/Entity/User.php
namespace App\Entity;

use App\Helper\PokerHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_hands")
 * @ORM\Entity(repositoryClass="App\Repository\HandRepository")
 */
class Hand
{

    /**
     * @ORM\ManyToOne(targetEntity="File", inversedBy="app_hands")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     **/
    public $file;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    public $id;

    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_1;

    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_2;

    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_3;


    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_4;


    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_5;

      /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_6;

    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_7;

    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_8;


    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_9;


    /**
     * @ORM\Column(type="string", length=2)
     **/
    public $card_10;






    public function getHandArray(){
        return [$this->card_1,$this->card_2,$this->card_3,$this->card_4,$this->card_5,$this->card_6,$this->card_7,$this->card_8,$this->card_9,$this->card_10];
    }

    public function getPlayerOneHandArray(){
        return [$this->card_1,$this->card_2,$this->card_3,$this->card_4,$this->card_5];
    }

    public function getPlayerTwoHandArray(){
        return [$this->card_6,$this->card_7,$this->card_8,$this->card_9,$this->card_10];
    }


    public function winner(){
        return PokerHelper::getWinner($this);
    }
}