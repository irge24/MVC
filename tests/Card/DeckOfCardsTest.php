<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $filledDeck = $deck->deck();
        $elementsDeck = count($filledDeck);
        $this->assertEquals(52, $elementsDeck);

        $shuffledDeck = $deck->shuffle();
        $this->assertNotEquals($filledDeck, $shuffledDeck);

        $aDeck = $deck->getDeck();
        $elementsADeck = count($aDeck);
        $this->assertEquals(52, $elementsADeck);
    }
}
