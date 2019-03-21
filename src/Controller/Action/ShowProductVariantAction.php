<?php

declare(strict_types=1);

namespace Setono\SyliusVariantLinkPlugin\Controller\Action;

use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ShowProductVariantAction
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var HttpKernelInterface
     */
    private $httpKernel;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(RequestStack $requestStack, HttpKernelInterface $httpKernel, EventDispatcherInterface $eventDispatcher)
    {
        $this->requestStack = $requestStack;
        $this->httpKernel = $httpKernel;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function __invoke(): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        if(null === $request) {
            throw new \RuntimeException('No current request'); // @todo better exception
        }

        $this->eventDispatcher->dispatch('setono_sylius_variant_link.product_variant.show');

        $attributes = array_merge($request->attributes->all(), ['_controller' => 'sylius.controller.product:showAction']);

        $subRequest = $request->duplicate(
            $request->query->all(),
            $request->request->all(),
            $attributes,
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all()
        );

        return $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
}
