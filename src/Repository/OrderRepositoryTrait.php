<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;

trait OrderRepositoryTrait
{
    public function getCartByCustomerAndChannelIdQueryBuilder($customerId, $channelId): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.customer = :customerId')
            ->andWhere('o.channel = :channelId')
            ->andWhere('o.state = :state')
            ->setParameter('customerId', $customerId)
            ->setParameter('channelId', $channelId)
            ->setParameter('state', OrderInterface::STATE_CART)
        ;
    }

    public function findOneByIdAndCustomer($id, $customerId): ?OrderInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :id')
            ->andWhere('o.customer = :customerId')
            ->setParameter('id', $id)
            ->setParameter('customerId', $customerId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
