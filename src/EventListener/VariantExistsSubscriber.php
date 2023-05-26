<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\EventListener;

use Safe\Exceptions\StringsException;
use Setono\SyliusVariantLinkPlugin\Request\VariantIdentifierTrait;
use Setono\SyliusVariantLinkPlugin\Resolver\ProductVariantFromIdentifierResolverInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The job of this listener is to check if an URL to a given variant exists
 * Say you have a product with two variants and the urls for these variants are
 *
 * /products/product1-code/variant1-code
 * /products/product1-code/variant2-code
 *
 * but you enter /products/product1-code/variant3-code then you will receive a 404
 */
final class VariantExistsSubscriber implements EventSubscriberInterface
{
    use VariantIdentifierTrait;

    public function __construct(
        private ProductVariantFromIdentifierResolverInterface $productVariantResolver,
        RequestStack $requestStack,
    ) {
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.product.show' => 'onShow',
        ];
    }

    public function onShow(ResourceControllerEvent $event): void
    {
        $product = $event->getSubject();

        if (!$product instanceof ProductInterface) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return;
        }

        if (!$this->hasVariantIdentifier()) {
            return;
        }

        $identifier = $this->getVariantIdentifier();

        $productVariant = $this->productVariantResolver->resolve($product, $identifier);

        if (null === $productVariant) {
            throw new NotFoundHttpException(
                sprintf(
                    'The product %s does not have a variant identified by %s',
                    $product->getCode(),
                    $identifier
                )
            );
        }
    }
}
