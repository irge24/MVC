<?php

namespace App\Entity;

use App\Repository\Indikator1Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Indikator1Repository::class)]
class Indikator1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?float $deaths = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDeaths(): ?float
    {
        return $this->deaths;
    }

    public function setDeaths(float $deaths): static
    {
        $this->deaths = $deaths;

        return $this;
    }
}
