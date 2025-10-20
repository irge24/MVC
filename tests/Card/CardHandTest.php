<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
        $card->setValueString("2♠");

        $cardHand->addCard($card);
        $this->assertEquals(["[2♠]"], $cardHand->getString());

        $secondCard = new Card();
        $secondCard->setValueString("3♠");
        $cardHand->addCard($secondCard);
        $this->assertEquals(["[2♠]", "[3♠]"], $cardHand->getString());
        $this->assertEquals(5, $cardHand->getTotalValue());
    }
}
