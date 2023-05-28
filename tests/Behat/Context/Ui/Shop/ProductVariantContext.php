<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusVariantLinkPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Shop\Product\ShowPageInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantContext implements Context
{
    /** @var ShowPageInterface */
    private $showPage;

    public function __construct(
        ShowPageInterface $showPage
    ) {
        $this->showPage = $showPage;
    }

    /**
     * @When /^I check the details for (variant "([^"]+)")$/
     */
    public function iCheckTheDetailsforVariant(ProductVariantInterface $productVariant): void
    {
        $localeCode = 'en_US';
        $product = $productVariant->getProduct();

        $this->showPage->open([
            'slug' => $product->getTranslation($localeCode)->getSlug(),
            'variant_identifier' => $productVariant->getCode(),
            '_locale' => $localeCode,
        ]);
    }
}
