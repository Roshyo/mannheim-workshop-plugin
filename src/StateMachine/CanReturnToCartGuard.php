<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\StateMachine;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutStates;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;

readonly class CanReturnToCartGuard
{
    public function __invoke(OrderInterface $order): bool
    {
        if (OrderCheckoutStates::STATE_COMPLETED !== $order->getCheckoutState()) {
            return false;
        }

        if (OrderPaymentStates::STATE_AWAITING_PAYMENT !== $order->getPaymentState()) {
            return false;
        }

        if (OrderShippingStates::STATE_READY !== $order->getShippingState()) {
            return false;
        }

        return true;
    }
}
