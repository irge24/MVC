<?php

namespace App\Entity;

use App\Repository\CovidDeathsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CovidDeathsRepository::class)]
class CovidDeaths
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column]
    private ?int $deaths = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column]
    private ?float $totalPercentage = null;

    #[ORM\Column]
    private ?int $men = null;

    #[ORM\Column]
    private ?float $menPercentage = null;

    #[ORM\Column]
    private ?int $women = null;

    #[ORM\Column]
    private ?float $womenPercentage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): static
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalPercentage(): ?float
    {
        return $this->totalPercentage;
    }

    public function setTotalPercentage(float $totalPercentage): static
    {
        $this->totalPercentage = $totalPercentage;

        return $this;
    }

    public function getMen(): ?int
    {
        return $this->men;
    }

    public function setMen(int $men): static
    {
        $this->men = $men;

        return $this;
    }

    public function getMenPercentage(): ?float
    {
        return $this->menPercentage;
    }

    public function setMenPercentage(float $menPercentage): static
    {
        $this->menPercentage = $menPercentage;

        return $this;
    }

    public function getWomen(): ?int
    {
        return $this->women;
    }

    public function setWomen(int $women): static
    {
        $this->women = $women;

        return $this;
    }

    public function getWomenPercentage(): ?float
    {
        return $this->womenPercentage;
    }

    public function setWomenPercentage(float $womenPercentage): static
    {
        $this->womenPercentage = $womenPercentage;

        return $this;
    }
}
