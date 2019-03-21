<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Request;

use Symfony\Component\HttpFoundation\Request;

trait VariantIdentifierTrait
{
    public function hasVariantIdentifier(Request $request): bool
    {
        return $request->attributes->has('variant_identifier');
    }

    public function getVariantIdentifier(Request $request): string
    {
        return $request->attributes->get('variant_identifier');
    }
}
