<?php

namespace App\Tests\Entity;

use App\Entity\Bibliotek;
use PHPUnit\Framework\TestCase;

class BibliotekTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $bibliotek = new Bibliotek();

        // Test setTitel och getTitel
        $this->assertSame($bibliotek, $bibliotek->setTitel('Testtitel'));
        $this->assertEquals('Testtitel', $bibliotek->getTitel());

        // Test setISBN och getISBN
        $this->assertSame($bibliotek, $bibliotek->setISBN('1234567890'));
        $this->assertEquals('1234567890', $bibliotek->getISBN());

        // Test setFörfattare och getFörfattare
        $this->assertSame($bibliotek, $bibliotek->setFörfattare('Författare Namn'));
        $this->assertEquals('Författare Namn', $bibliotek->getFörfattare());

        // Test setBild och getBild
        $this->assertSame($bibliotek, $bibliotek->setBild('bild.jpg'));
        $this->assertEquals('bild.jpg', $bibliotek->getBild());

        // Test getId (får vara null vid ny entity)
        $this->assertNull($bibliotek->getId());
    }
}
