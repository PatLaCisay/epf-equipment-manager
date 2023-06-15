<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItemRepository;
use Symfony\Component\Asset\Package;
use Symfony\Config\Framework\AssetsConfig;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

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

    #[ORM\ManyToOne(inversedBy: 'items')]
    // #[Assert\Valid]
    #[Assert\NotNull]
    private ?Category $category;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = 1;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ItemBorrow::class, orphanRemoval: true)]
    private Collection $borrow;

    #[ORM\Column]
    private ?int $stock = null;

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
        return base64_encode(stream_get_contents($this->image));
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function setDefaultImage($kdir)
    {
        $this->image=file_get_contents(join(DIRECTORY_SEPARATOR, array($kdir,"public", "img", "default-placeholder.png")));

    }

}
