<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\LivresRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Contrainst as Assert;

#[ORM\Entity(repositoryClass: LivresRepository::class)]
#[UniqueEntity('name')]
class Livres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Unique()]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private string $name;

    #[ORM\Column(type: 'float')]
    #[Assert\NotNull()]
    #[Assert\Positive()]
    #[Assert\LessThan(200)]
    private float $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $datecraft;

    /**
     * Construtor date avec faker php
     */
    public function __construct()
    {
        $this->datecraft = new \DateTimeImmutable();
    }


    #[ORM\Column(type: 'string', length: 2000)]
    #[Assert\NotBlank()]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'author')]
    #[Assert\NotBlank()]
    private string $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDatecraft(): ?\DateTimeImmutable
    {
        return $this->datecraft;
    }

    public function setDatecraft(\DateTimeImmutable $datecraft): self
    {
        $this->datecraft = $datecraft;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
