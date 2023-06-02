<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 100, enumType: ItemState::class)]
    private $state;

    #[ORM\ManyToOne(inversedBy: 'items')]
    // #[Assert\Valid]
    #[Assert\NotNull]
    private ?Category $category;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ItemBorrow::class, orphanRemoval: true)]
    private Collection $borrow;

    public function __construct()
    {
        $this->borrow = new ArrayCollection();
    }

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

    public function getState(): ?ItemState
    {
        return $this->state;
    }

    public function setState(ItemState $state): self
    {
        $this->state = $state;

        return $this;
    }
    
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

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

    /**
     * @return Collection<int, Borrow>
     */
    public function getBorrow(): Collection
    {
        return $this->borrow;
    }

}
