<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\UrlGenerator;

use Sylius\Component\Product\Model\ProductVariantInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

interface ProductVariantUrlGeneratorInterface
{
    /**
     * Will generate an URL for a product variant
     *
     * @param array $parameters Will be merged together with the parameters used to generate the url to the variant
     * @param int $referenceType Is passed on to the underlying Symfony url generator
     */
    public function generate(
        ProductVariantInterface $productVariant,
        array $parameters = [],
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string;
}
