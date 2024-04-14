<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\Order;

interface OrderTransitions extends \Sylius\Component\Order\OrderTransitions
{
    public const TRANSITION_RETURN_TO_CART = 'return_to_cart';
}
