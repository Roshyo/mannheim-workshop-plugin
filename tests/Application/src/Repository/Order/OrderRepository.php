<?php

declare(strict_types=1);

namespace Tests\Sylius\AbandonedCartPlugin\Application\src\Repository\Order;

use Sylius\AbandonedCartPlugin\Repository\OrderRepositoryTrait;

class OrderRepository extends \Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository
{
    use OrderRepositoryTrait;
}
