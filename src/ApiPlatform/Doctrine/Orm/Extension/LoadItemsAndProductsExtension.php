<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\ApiPlatform\Doctrine\Orm\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

final class LoadItemsAndProductsExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass = null, Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
    }

    private function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, ?string $resourceClass, ?Operation $operation, array $context): void
    {
        if (null === $resourceClass) {
            throw new InvalidArgumentException('The "$resourceClass" parameter must not be null');
        }

        if ($resourceClass !== Order::class) {
            return;
        }

//        $queryBuilder
//            ->addSelect('oi', 'p')
//            ->join(OrderItem::class, 'oi', Join::WITH, 'oi.originOrder = o')
//            ->join(Product::class, 'p', Join::WITH, 'oi.product = p')
//        ;
    }
}
