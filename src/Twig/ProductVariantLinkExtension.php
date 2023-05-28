<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Twig;

use Setono\SyliusVariantLinkPlugin\UrlGenerator\ProductVariantUrlGeneratorInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
            new TwigFunction('setono_variant_path', [$this, 'path']),
            new TwigFunction('setono_variant_url', [$this, 'url']),
        ];
    }

    public function path(ProductVariantInterface $productVariant, array $parameters = []): string
    {
        return $this->productVariantUrlGenerator->generate($productVariant, $parameters);
    }

    public function url(ProductVariantInterface $productVariant, array $parameters = []): string
    {
        return $this->productVariantUrlGenerator->generate(
            $productVariant,
            $parameters,
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
