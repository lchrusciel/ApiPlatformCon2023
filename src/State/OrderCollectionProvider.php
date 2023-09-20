<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\OrderRepository;

class OrderCollectionProvider implements ProviderInterface
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->orderRepository->findWithItemsAndProducts();
    }
}
