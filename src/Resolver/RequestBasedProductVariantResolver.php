<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Resolver;

use Setono\SyliusVariantLinkPlugin\Request\VariantIdentifierTrait;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductInterface as BaseProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface as BaseProductVariantResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class RequestBasedProductVariantResolver implements BaseProductVariantResolverInterface
{
    use VariantIdentifierTrait;

    public function __construct(
        private BaseProductVariantResolverInterface $decoratedProductVariantResolver,
        private ProductVariantFromIdentifierResolverInterface $productVariantFromIdentifierResolver,
        RequestStack $requestStack,
    ) {
        $this->requestStack = $requestStack;
    }

    public function getVariant(BaseProductInterface $product): ?ProductVariantInterface
    {
        if (!$this->hasVariantIdentifier()) {
            return $this->decoratedProductVariantResolver->getVariant($product);
        }

        if (!$product instanceof ProductInterface) {
            return $this->decoratedProductVariantResolver->getVariant($product);
        }

        $variant = $this->productVariantFromIdentifierResolver->resolve($product, $this->getVariantIdentifier());
        if (null === $variant) {
            return $this->decoratedProductVariantResolver->getVariant($product);
        }

        return $variant;
    }
}
