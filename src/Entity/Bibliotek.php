<?php

namespace App\Entity;

use App\Repository\BibliotekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BibliotekRepository::class)]
class Bibliotek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titel = null;

    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[ORM\Column(length: 255)]
    private ?string $författare = null;

    #[ORM\Column(length: 255)]
    private ?string $bild = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): static
    {
        $this->titel = $titel;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getFörfattare(): ?string
    {
        return $this->författare;
    }

    public function setFörfattare(string $författare): static
    {
        $this->författare = $författare;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(string $bild): static
    {
        $this->bild = $bild;

        return $this;
    }
}
