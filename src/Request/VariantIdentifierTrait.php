<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Request;

use Symfony\Component\HttpFoundation\RequestStack;

trait VariantIdentifierTrait
{
    /** @var RequestStack */
    private $requestStack;

    private function hasVariantIdentifier(): bool
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return false;
        }

        return $request->attributes->has('variant_identifier');
    }

    public function getVariantIdentifier(): string
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return '';
        }

        return $request->attributes->get('variant_identifier');
    }
}
