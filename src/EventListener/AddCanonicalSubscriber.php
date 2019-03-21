<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\EventListener;

use Fig\Link\GenericLinkProvider;
use Fig\Link\Link;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

final class AddCanonicalSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RequestStack $requestStack, RouterInterface $router)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'setono_sylius_variant_link.product_variant.show' => [
                'onShow',
            ],
        ];
    }

    public function onShow(): void
    {
        $request = $this->requestStack->getMasterRequest();
        if(null === $request) {
            return;
        }

        $uri = $this->router->generate('sylius_shop_product_show', [
            'slug' => $request->attributes->get('slug')
        ], RouterInterface::ABSOLUTE_URL);

        $link = new Link('canonical', $uri);
        $linkProvider = $request->attributes->get('_links', new GenericLinkProvider());
        $request->attributes->set('_links', $linkProvider->withLink($link));
    }
}
