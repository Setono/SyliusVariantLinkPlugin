<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Twig;

use Setono\SyliusVariantLinkPlugin\UrlGenerator\ProductVariantUrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ProductVariantLinkExtension extends AbstractExtension
{
    /** @var ProductVariantUrlGeneratorInterface */
    private $productVariantUrlGenerator;

    public function __construct(ProductVariantUrlGeneratorInterface $productVariantUrlGenerator)
    {
        $this->productVariantUrlGenerator = $productVariantUrlGenerator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setono_variant_link', [$this->productVariantUrlGenerator, 'generate']),
        ];
    }
}
