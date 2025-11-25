<?php

namespace App\Tests\Entity;

use App\Entity\CovidDeaths;
use PHPUnit\Framework\TestCase;

class CovidDeathsTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $covid = new CovidDeaths();

        // Test setAge och getAge
        $this->assertSame($covid, $covid->setAge('30-39'));
        $this->assertEquals('30-39', $covid->getAge());

        // Test setDeaths och getDeaths
        $this->assertSame($covid, $covid->setDeaths(100));
        $this->assertEquals(100, $covid->getDeaths());

        // Test setTotal och getTotal
        $this->assertSame($covid, $covid->setTotal(500));
        $this->assertEquals(500, $covid->getTotal());

        // Test setTotalPercentage och getTotalPercentage
        $this->assertSame($covid, $covid->setTotalPercentage(20.5));
        $this->assertEquals(20.5, $covid->getTotalPercentage());

        // Test setMen och getMen
        $this->assertSame($covid, $covid->setMen(60));
        $this->assertEquals(60, $covid->getMen());

        // Test setMenPercentage och getMenPercentage
        $this->assertSame($covid, $covid->setMenPercentage(12.0));
        $this->assertEquals(12.0, $covid->getMenPercentage());

        // Test setWomen och getWomen
        $this->assertSame($covid, $covid->setWomen(40));
        $this->assertEquals(40, $covid->getWomen());

        // Test setWomenPercentage och getWomenPercentage
        $this->assertSame($covid, $covid->setWomenPercentage(8.0));
        $this->assertEquals(8.0, $covid->getWomenPercentage());

        // Test getId (ska vara null på ny entity)
        $this->assertNull($covid->getId());
    }
}
