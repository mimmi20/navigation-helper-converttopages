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
use Laminas\Stdlib\ArrayUtils;
use Mimmi20\Mezzio\Navigation\ContainerInterface;
use Mimmi20\Mezzio\Navigation\Exception\InvalidArgumentException;
use Mimmi20\Mezzio\Navigation\Page\PageFactoryInterface;
use Mimmi20\Mezzio\Navigation\Page\PageInterface;
use Override;
use Traversable;

use function array_map;
use function assert;
use function is_array;
use function is_numeric;
use function is_string;
use function key;

final readonly class ConvertToPages implements ConvertToPagesInterface
{
    /** @throws void */
    public function __construct(private PageFactoryInterface | null $pageFactory)
    {
        // nothing to do
    }

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
    #[Override]
    public function convert(
        AbstractContainer | AbstractPage | iterable | ContainerInterface | int | PageInterface | string $mixed,
        bool $recursive = true,
    ): array {
        if ($mixed instanceof PageInterface || $mixed instanceof AbstractPage) {
            // value is a page instance; return directly
            return [$mixed];
        }

        if ($mixed instanceof ContainerInterface || $mixed instanceof AbstractContainer) {
            // value is a container; return pages in it
            $pages = [];

            foreach ($mixed as $page) {
                assert($page instanceof PageInterface || $page instanceof AbstractPage);
                $pages[] = $page;
            }

            return $pages;
        }

        if (is_string($mixed)) {
            // value is a string; make a URI page
            try {
                $page = $this->pageFactory?->factory(
                    [
                        'type' => 'uri',
                        'uri' => $mixed,
                    ],
                ) ?? AbstractPage::factory(
                    [
                        'type' => 'uri',
                        'uri' => $mixed,
                    ],
                );

                return [$page];
            } catch (\Laminas\Navigation\Exception\InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
            }
        }

        if ($mixed instanceof Traversable) {
            try {
                $mixed = ArrayUtils::iteratorToArray($mixed);
            } catch (\Laminas\Stdlib\Exception\InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
            }
        }

        if (is_array($mixed) && $mixed !== []) {
            if ($recursive && is_numeric(key($mixed))) {
                // first key is numeric; assume several pages
                return array_map(
                    /** @return AbstractPage|PageInterface */
                    function (AbstractContainer | AbstractPage | iterable | ContainerInterface | int | PageInterface | string $value) {
                        [$page] = $this->convert($value, false);

                        return $page;
                    },
                    $mixed,
                );
            }

            // pass array to factory directly
            try {
                $page = $this->pageFactory?->factory($mixed) ?? AbstractPage::factory($mixed);

                return [$page];
            } catch (\Laminas\Navigation\Exception\InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
            }
        }

        // nothing found
        return [];
    }
}
