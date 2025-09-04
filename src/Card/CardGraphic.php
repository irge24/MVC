<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $values = [
        'A', 
        '2', 
        '3', 
        '4', 
        '5', 
        '6', 
        '7', 
        '8', 
        '9', 
        '10', 
        'J', 
        'Q', 
        'K'
    ];

    private $colours = [
        '♠', 
        '♥', 
        '♦', 
        '♣'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {

        $a_card = $this->values[($this->value - 1) % 13] . $this->colours[floor(($this->value - 1) / 13)];

        return $a_card;
    }
}