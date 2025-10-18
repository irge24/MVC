<?php

namespace App\Card;

class Card
{
    protected $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function aCard(array $cardDeck): array
    {
        $aCard = array_shift($cardDeck);
        $newDeck = $cardDeck;

        $this->value = $aCard;
        return [$aCard, $newDeck];
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getNumberValue(): int
    {

        $rank = mb_substr($this->value, 0, -1); // tar bort sista tecknet (färgen), bara siffran kvar

        // Returnera värde
        if ($rank === 'J') {
        return 11;
        } elseif ($rank === 'Q') {
        return 12;
        } elseif ($rank === 'K') {
        return 13;
        } elseif ($rank === 'A') {
        return 14;
        } else {
            return (int)$rank;
        }
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function setValueString(string $value): void
    {
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
