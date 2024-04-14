<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\Shipping;

interface ShipmentTransitions extends \Sylius\Component\Shipping\ShipmentTransitions
{
    public const TRANSITION_RESTART = 'restart';
}
