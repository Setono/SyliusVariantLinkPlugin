<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Resolver;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantByCodeResolver implements ProductVariantResolverInterface
{
    public function resolve(ProductInterface $product, string $identifier): ?ProductVariantInterface
    {
        foreach ($product->getVariants() as $variant) {
            if($variant->getCode() === $identifier) {
                return $variant;
            }
        }

        return null;
    }
}
