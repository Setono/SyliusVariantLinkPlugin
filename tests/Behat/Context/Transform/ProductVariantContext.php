<?php
declare(strict_types=1);

namespace Tests\Setono\SyliusVariantLinkPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductVariantContext implements Context
{
    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    public function __construct(ProductVariantRepositoryInterface $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * @Transform /^variant "([^"]+)"$/
     */
    public function getProductByName($name)
    {
        $variants = $this->productVariantRepository->findByName($name, 'en_US');

        Assert::eq(
            count($variants),
            1,
            sprintf('%d product variants has been found with name "%s".', count($variants), $name)
        );

        return $variants[0];
    }
}
