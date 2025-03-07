<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $name = null;

    /**
     * @var Collection<int, Candy>
     */
    #[ORM\ManyToMany(targetEntity: Candy::class, mappedBy: 'colors')]
    private Collection $candies;

    public function __construct()
    {
        $this->candies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Candy>
     */
    public function getCandies(): Collection
    {
        return $this->candies;
    }

    public function addCandy(Candy $candy): static
    {
        if (!$this->candies->contains($candy)) {
            $this->candies->add($candy);
            $candy->addColor($this);
        }

        return $this;
    }

    public function removeCandy(Candy $candy): static
    {
        if ($this->candies->removeElement($candy)) {
            $candy->removeColor($this);
        }

        return $this;
    }
}
