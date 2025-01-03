<?php

/**
 * This file is part of the mimmi20/navigation-helper-converttopages package.
 *
 * Copyright (c) 2021-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\NavigationHelper\ConvertToPages;

use Mimmi20\Mezzio\Navigation\Page\PageFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class ConvertToPagesFactory
{
    /**
     * Create and return a navigation view helper instance.
     *
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ConvertToPages
    {
        $pageFactory = null;

        if ($container->has(PageFactoryInterface::class)) {
            $pageFactory = $container->get(PageFactoryInterface::class);

            assert($pageFactory instanceof PageFactoryInterface);
        }

        return new ConvertToPages($pageFactory);
    }
}
