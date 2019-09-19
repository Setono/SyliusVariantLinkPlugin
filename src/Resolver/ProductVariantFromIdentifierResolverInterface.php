<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Resolver;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface ProductVariantFromIdentifierResolverInterface
{
    /**
     * Will try to resolve a product variant on the product from the given identifier
     * If no variant exists on the product for this identifier it returns null
     */
    public function resolve(ProductInterface $product, string $identifier): ?ProductVariantInterface;
}
