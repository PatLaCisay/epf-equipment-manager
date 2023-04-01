<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 100)]
    private $state;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Type::class)]
    private $type;

    #[ORM\ManyToMany(targetEntity: Borrow::class, inversedBy: 'items')]
    private Collection $borrow;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Type $typeOf = null;

    public function __construct()
    {
        $this->type = new ArrayCollection();
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }


    /**
     * @return Collection<int, Borrow>
     */
    public function getBorrow(): Collection
    {
        return $this->borrow;
    }

    public function addBorrow(Borrow $borrow): self
    {
        if (!$this->borrow->contains($borrow)) {
            $this->borrow->add($borrow);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): self
    {
        $this->borrow->removeElement($borrow);

        return $this;
    }

    public function getTypeOf(): ?Type
    {
        return $this->typeOf;
    }

    public function setTypeOf(?Type $typeOf): self
    {
        $this->typeOf = $typeOf;

        return $this;
    }
}
