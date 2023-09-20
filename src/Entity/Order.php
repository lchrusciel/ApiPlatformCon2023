<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'originOrder', targetEntity: OrderItem::class, cascade: ['all'], orphanRemoval: true, fetch: 'EAGER')]
    private Collection $orderItems;

    public function __construct(array $orderItems)
    {
        $this->orderItems = new ArrayCollection();
        foreach ($orderItems as $orderItem) {
            $this->addOrderItem($orderItem);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function getTotal(): int
    {
         return (int) $this->orderItems->reduce(fn (int $currentValue, OrderItem $item) => $currentValue + $item->getPrice(), 0);
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOriginOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOriginOrder() === $this) {
                $orderItem->setOriginOrder(null);
            }
        }

        return $this;
    }
}
