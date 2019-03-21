<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\EventListener;

use Setono\SyliusVariantLinkPlugin\Request\VariantIdentifierTrait;
use Setono\SyliusVariantLinkPlugin\Resolver\ProductVariantResolverInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class VariantExistsSubscriber implements EventSubscriberInterface
{
    use VariantIdentifierTrait;

    /**
     * @var ProductVariantResolverInterface
     */
    private $productVariantResolver;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(ProductVariantResolverInterface $productVariantResolver, RequestStack $requestStack)
    {
        $this->productVariantResolver = $productVariantResolver;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.product.show' => [
                'onShow',
            ],
        ];
    }

    public function onShow(ResourceControllerEvent $event): void
    {
        $product = $event->getSubject();

        if(!$product instanceof ProductInterface) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if(null === $request) {
            return;
        }

        if($this->hasVariantIdentifier($request)) {
            return;
        }

        $identifier = $this->getVariantIdentifier($request);

        $productVariant = $this->productVariantResolver->resolve($product, $identifier);

        if(null === $productVariant) {
            throw new NotFoundHttpException(sprintf('The product %s does not have a variant identified by %s', $product->getCode(), $identifier));
        }
    }
}
