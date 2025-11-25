<?php

namespace App\Tests\Entity;

use App\Entity\Indikator1;
use PHPUnit\Framework\TestCase;

class Indikator1Test extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $indikator = new Indikator1();

        // Test setYear och getYear
        $this->assertSame($indikator, $indikator->setYear(2025));
        $this->assertEquals(2025, $indikator->getYear());

        // Test setDeaths och getDeaths
        $this->assertSame($indikator, $indikator->setDeaths(123.45));
        $this->assertEquals(123.45, $indikator->getDeaths());

        // Test getId (ska vara null på ny entity)
        $this->assertNull($indikator->getId());
    }
}
