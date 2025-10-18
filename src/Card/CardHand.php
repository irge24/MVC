<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /** @var Card[] */
    private array $hand = [];

    public function addCard(Card $aCard): void
    {
        $this->hand[] = $aCard;
    }

    public function getTotalValue(): int
    {
        $total = 0;
        foreach ($this->hand as $aCard) {
            $total += $aCard->getNumberValue();
        }
        return $total;
    }

    /**
     * @return string[]
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $aCard) {
            $values[] = $aCard->getAsString();
        }
        return $values;
    }
}
