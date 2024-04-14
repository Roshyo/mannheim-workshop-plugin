<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\MenuListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class ShopAccountMenuListener
{
    public function addAccountMenuItem(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('carts', ['route' => 'sylius_abandoned_cart_shop_account_carts'])
            ->setLabel('sylius.ui.carts')
            ->setLabelAttribute('icon', 'cart')
        ;
    }
}
