<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgJPG;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgPNG;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Unity;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stock", mappedBy="product", cascade={"persist", "remove"})
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="products")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="product")
     */
    private $news;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->news = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImgJPG(): ?string
    {
        return $this->imgJPG;
    }

    public function setImgJPG(string $imgJPG): self
    {
        $this->imgJPG = $imgJPG;

        return $this;
    }

    public function getImgPNG(): ?string
    {
        return $this->imgPNG;
    }

    public function setImgPNG(string $imgPNG): self
    {
        $this->imgPNG = $imgPNG;

        return $this;
    }


    public function getUnity(): ?string
    {
        return $this->Unity;
    }

    public function setUnity(string $Unity): self
    {
        $this->Unity = $Unity;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;

        // set the owning side of the relation if necessary
        if ($stock->getProduct() !== $this) {
            $stock->setProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setProducts($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getProducts() === $this) {
                $order->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|News[]
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setProduct($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->contains($news)) {
            $this->news->removeElement($news);
            // set the owning side to null (unless already changed)
            if ($news->getProduct() === $this) {
                $news->setProduct(null);
            }
        }

        return $this;
    }
}
