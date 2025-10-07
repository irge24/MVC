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

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
