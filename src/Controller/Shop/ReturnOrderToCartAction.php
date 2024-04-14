<?php

declare(strict_types=1);

namespace Sylius\AbandonedCartPlugin\Controller\Shop;

use Doctrine\Persistence\ObjectManager;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\OrderBundle\Context\SessionBasedCartContext;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\OrderTransitions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ReturnOrderToCartAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ShopperContextInterface $shopperContext,
        private FactoryInterface $stateMachineFactory,
        private ObjectManager $orderManager,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(Request $request, string $tokenValue): Response
    {
        $customer = $this->shopperContext->getCustomer();
        if (null === $customer) {
            throw new NotFoundHttpException('Customer not found');
        }

        /** @var OrderInterface|null $order */
        $order = $this->orderRepository->findOneBy(['tokenValue' => $tokenValue, 'customer' => $customer]);
        if (null === $order || $customer !== $order->getCustomer()) {
            throw new NotFoundHttpException('Order not found');
        }

        $stateMachine = $this->stateMachineFactory->get($order, OrderTransitions::GRAPH);
        $stateMachine->apply(\Sylius\AbandonedCartPlugin\Order\OrderTransitions::TRANSITION_RETURN_TO_CART);

        $order->setCreatedAt(new \DateTime('now'));

        $this->orderManager->flush();

        return new RedirectResponse($this->urlGenerator->generate('sylius_shop_cart_summary'));
    }
}
