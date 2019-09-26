<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\UrlGenerator;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webmozart\Assert\Assert;

final class ProductVariantFromCodeUrlGenerator implements ProductVariantUrlGeneratorInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(ProductVariantInterface $productVariant, bool $absolute = false): string
    {
        $product = $productVariant->getProduct();
        Assert::notNull($product);

        return $this->urlGenerator->generate('setono_sylius_variant_link_shop_product_variant_show', [
            'slug' => $product->getSlug(),
            'variant_identifier' => $productVariant->getCode(),
        ], $absolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH);
    }
}
