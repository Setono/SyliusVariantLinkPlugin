<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\UrlGenerator;

use Sylius\Component\Product\Model\ProductVariantInterface;

interface ProductVariantUrlGeneratorInterface
{
    /**
     * Will generate an URL for a product variant
     */
    public function generate(ProductVariantInterface $productVariant, bool $absolute = false): string;
}
