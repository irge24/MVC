<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCards
{
    private array $deck = [];

    public function __construct()
    {
        $this->deck = [];
    }

    public function deck(): array
    {
        $this->deck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValue($i);
            $this->deck[] = $card->getAsString();
        }

        return $this->deck;
    }

    public function shuffle(): array
    {
        $this->deck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValue($i);
            $this->deck[] = $card->getAsString();
        }

        shuffle($this->deck);

        return $this->deck;
    }

    public function getDeck(): array
    {
        return $this->deck;
    }
}
