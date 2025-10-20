<?php

namespace App\Card;

/**
 * Class CardGraphic
 *
 * Ett spelkort med värde och färg i grafisk form.
 * Ärver från klassen Card.
 */
class CardGraphic extends Card
{
    /**
     * @var string[] $values Kortens värden.
     */
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

    /**
     * @var string[] $colours Kortens färger.
     */
    private array $colours = [
        '♠',
        '♥',
        '♦',
        '♣'
    ];

    /**
     * Skapar nytt grafiskt kortobjekt.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returnerar kortet som sträng.
     *
     * @return string $aCard Kortet.
     */
    public function getAsString(): string
    {

        $val = (int) $this->value; // säkerställ int

        $aCard = $this->values[($val - 1) % 13]
                . $this->colours[floor(($val - 1) / 13)];

        return $aCard;
    }
}
