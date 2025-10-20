<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Kontrollera att rätta värde fås.
     */
    public function testValueOfCard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card->setValueString("10♠");

        $this->assertEquals("10♠", $card->getValue());
        $this->assertEquals(10, $card->getNumberValue());
    }

    /**
     * Testa aCard() metoden.
     */
    public function testACard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);

        $deck = ["2♠", "3♣", "4♥"];
        $res = $card->aCard($deck);
        $aCard = $res[0];
        $newDeck = $res[1];

        $this->assertEquals("2♠", $aCard);
        $this->assertEquals("3♣", $newDeck[0]);
        $this->assertEquals("4♥", $newDeck[1]);
    }

    /**
     * Kontrollera att rätta värde fås med metod getNumberValue().
     */
    public function testGetNumberValue(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);

        $this->assertEquals(0, $card->getNumberValue());

        $card->setValueString("J♠");
        $this->assertEquals(11, $card->getNumberValue());

        $card->setValueString("Q♠");
        $this->assertEquals(12, $card->getNumberValue());

        $card->setValueString("K♠");
        $this->assertEquals(13, $card->getNumberValue());

        $card->setValueString("A♠");
        $this->assertEquals(14, $card->getNumberValue());
    }
}
