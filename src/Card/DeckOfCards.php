<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    /** @var string[] */
    private array $deck = [];

    public function __construct()
    {
        $this->deck = [];
    }

    /**
     * @return string[]
     */
    public function deck(): array
    {
        $this->deck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValueString((string)$i);
            $this->deck[] = $card->getAsString();
        }

        return $this->deck;
    }

    /**
     * @return string[]
     */
    public function shuffle(): array
    {
        $this->deck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValueString((string)$i);
            $this->deck[] = $card->getAsString();
        }

        shuffle($this->deck);

        return $this->deck;
    }

    /**
     * @return string[]
     */
    public function getDeck(): array
    {
        return $this->deck;
    }
}
