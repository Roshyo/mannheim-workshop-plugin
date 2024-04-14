<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\StateMachine;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;

readonly class CancelLastPayment
{
    public function __invoke(OrderInterface $order): void
    {
        $lastUnpaidPayment = $order->getLastPayment(PaymentInterface::STATE_NEW);
        if (null !== $lastUnpaidPayment) {
            $order->removePayment($lastUnpaidPayment);
        }
    }
}
