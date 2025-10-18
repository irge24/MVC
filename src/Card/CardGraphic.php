<?php

namespace App\Card;

class CardGraphic extends Card
{
    /** @var string[] */
    private array $values = [
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

    /** @var string[] */
    private array $colours = [
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

        $val = (int) $this->value; // säkerställ int

        $aCard = $this->values[($val - 1) % 13]
                . $this->colours[floor(($val - 1) / 13)];

        return $aCard;
    }
}
