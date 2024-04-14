<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\StateMachine;

use SM\Factory\FactoryInterface;
use SM\SMException;
use Sylius\AbandonedCartPlugin\Exception\RestartOrderException;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Shipping\ShipmentTransitions;

readonly class RestartShipments
{
    public function __construct(
        private FactoryInterface $stateMachineFactory,
    ) {
    }

    public function __invoke(OrderInterface $order): void
    {
        $shipments = $order->getShipments();
        foreach ($shipments as $shipment) {
            try {
                $stateMachine = $this->stateMachineFactory->get($shipment, ShipmentTransitions::GRAPH);
                $stateMachine->apply(\Sylius\AbandonedCartPlugin\Shipping\ShipmentTransitions::TRANSITION_RESTART);
            } catch (SMException $e) {
                throw new RestartOrderException(previous: $e);
            }
        }
    }
}
