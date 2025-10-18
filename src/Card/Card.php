<?php

namespace App\Card;

class Card
{
    protected ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    /**
     * Draw a card from the deck.
     *
     * @param string[] $cardDeck  Array of card strings.
     * @return array{0: string|null, 1: string[]}  The drawn card and the remaining deck.
     */
    public function aCard(array $cardDeck): array
    {
        $aCard = array_shift($cardDeck);
        $newDeck = $cardDeck;

        $this->value = $aCard;
        return [$aCard, $newDeck];
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getNumberValue(): int
    {

        if ($this->value === null) {
            return 0;
        }

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
        } 

        return (int)$rank;
    }

    //public function setValue(int $value): void
    //{
        //$this->value = $value;
    //}

    public function setValueString(string $value): void
    {
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
