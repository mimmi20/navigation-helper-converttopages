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

use Laminas\Navigation\AbstractContainer;
use Laminas\Navigation\Page\AbstractPage;
use Laminas\Stdlib\Exception\InvalidArgumentException;
use Mimmi20\Mezzio\Navigation\ContainerInterface;
use Mimmi20\Mezzio\Navigation\Page\PageInterface;

interface ConvertToPagesInterface
{
    /**
     * Converts a $mixed value to an array of pages
     *
     * @param AbstractContainer<AbstractPage>|AbstractPage|ContainerInterface<PageInterface>|int|iterable<iterable<string>|string>|PageInterface|string $mixed     mixed value to get page(s) from
     * @param bool                                                                                                                                      $recursive whether $value should be looped if it is an array or a config
     *
     * @return array<int|string, AbstractPage|PageInterface>
     *
     * @throws InvalidArgumentException
     */
    public function convert(
        AbstractContainer | AbstractPage | iterable | ContainerInterface | int | PageInterface | string $mixed,
        bool $recursive = true,
    ): array;
}
