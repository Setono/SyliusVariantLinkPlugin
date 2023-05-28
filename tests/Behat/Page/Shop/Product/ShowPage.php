<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusVariantLinkPlugin\Behat\Page\Shop\Product;

use Sylius\Behat\Page\Shop\Product\ShowPage as BaseShowPage;

final class ShowPage extends BaseShowPage
{
    public function getRouteName(): string
    {
        return 'setono_sylius_variant_link_shop_product_variant_show';
    }
}
