<?php

namespace App\Entity;

use App\Repository\BorrowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
class Borrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Assert\Type(\DateTimeImmutable::class)]
    private $startDate;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\Expression(
        expression: "this.getStartDate() <= this.getEndDate()",
        message: "La date de fin doit être postérieure à la date de début.",
    )]
    private $endDate;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $returnDescription;

    #[ORM\Column(type: 'boolean')]
    private $restituted = false;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    #[ORM\JoinColumn(nullable: false)]
    private User $stakeholder;

    #[ORM\OneToMany(mappedBy: 'borrow', targetEntity: ItemBorrow::class)]
    private Collection $item;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $projectManager = null;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReturnDescription(): ?string
    {
        return $this->returnDescription;
    }

    public function setReturnDescription(?string $returnDescription): self
    {
        $this->returnDescription = $returnDescription;

        return $this;
    }

    public function isRestituted(): ?bool
    {
        return $this->restituted;
    }

    public function setRestituted(bool $restituted): self
    {
        $this->restituted = $restituted;

        return $this;
    }

    public function getStakeholder(): User
    {
        return $this->stakeholder;
    }

    public function setStakeholder(User $stakeholder): self
    {
        $this->stakeholder = $stakeholder;

        return $this;
    }

    /**
     * @return Collection<int, ItemBorrow>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(ItemBorrow $item): self
    {
        if (!$this->item->contains($item)) {
            $this->item->add($item);
            $item->setBorrow($this);
        }

        return $this;
    }

    public function removeItem(ItemBorrow $item): self
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getBorrow() === $this) {
                $item->setBorrow(null);
            }
        }

        return $this;
    }

    public function getProjectManager(): ?User
    {
        return $this->projectManager;
    }

    public function setProjectManager(?User $projectManager): self
    {
        $this->projectManager = $projectManager;

        return $this;
    }
}
