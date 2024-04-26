<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $catName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCatName(): ?string
    {
        return $this->catName;
    }

    public function setCatName(string $catName): static
    {
        $this->catName = $catName;

        return $this;
    }
}
