<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\EventListener;

use Psr\Link\EvolvableLinkProviderInterface;
use Setono\SyliusVariantLinkPlugin\Request\VariantIdentifierTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\WebLink\GenericLinkProvider;
use Symfony\Component\WebLink\Link;

/**
 * This class will add a canonical header from variant urls to their respective product urls
 */
final class AddCanonicalSubscriber implements EventSubscriberInterface
{
    use VariantIdentifierTrait;

    /** @var RouterInterface */
    private $router;

    /** @var EvolvableLinkProviderInterface */
    private $linkProvider;

    public function __construct(
        RequestStack $requestStack,
        RouterInterface $router,
        EvolvableLinkProviderInterface $linkProvider = null
    ) {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->linkProvider = $linkProvider ?? new GenericLinkProvider();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.product.show' => 'onShow',
        ];
    }

    public function onShow(): void
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return;
        }

        if (!$this->hasVariantIdentifier()) {
            return;
        }

        $uri = $this->router->generate('sylius_shop_product_show', [
            'slug' => $request->attributes->get('slug'),
        ], RouterInterface::ABSOLUTE_URL);

        $link = new Link('canonical', $uri);
        $linkProvider = $request->attributes->get('_links', $this->linkProvider);
        $request->attributes->set('_links', $linkProvider->withLink($link));
    }
}
