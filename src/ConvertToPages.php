<?php
/**
 * This file is part of the mimmi20/navigation-helper-converttopages package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\NavigationHelper\ConvertToPages;

use Laminas\Log\Logger;
use Laminas\Navigation\AbstractContainer;
use Laminas\Navigation\Page\AbstractPage;
use Laminas\Stdlib\ArrayUtils;
use Mezzio\Navigation\ContainerInterface;
use Mezzio\Navigation\Exception\InvalidArgumentException;
use Mezzio\Navigation\Page\PageFactoryInterface;
use Mezzio\Navigation\Page\PageInterface;
use Traversable;

use function array_map;
use function is_array;
use function is_numeric;
use function is_string;
use function key;

final class ConvertToPages implements ConvertToPagesInterface
{
    private Logger $logger;

    private ?PageFactoryInterface $pageFactory = null;

    public function __construct(Logger $logger, ?PageFactoryInterface $pageFactory)
    {
        $this->logger      = $logger;
        $this->pageFactory = $pageFactory;
    }

    /**
     * Converts a $mixed value to an array of pages
     *
     * @param AbstractContainer|AbstractPage|array<int|string, array<string>|string>|ContainerInterface|int|PageInterface|string|Traversable $mixed     mixed value to get page(s) from
     * @param bool                                                                                                                           $recursive whether $value should be looped if it is an array or a config
     *
     * @return array<int, AbstractPage|PageInterface>
     *
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function convert($mixed, bool $recursive = true): array
    {
        if ($mixed instanceof PageInterface || $mixed instanceof AbstractPage) {
            // value is a page instance; return directly
            return [$mixed];
        }

        if ($mixed instanceof ContainerInterface || $mixed instanceof AbstractContainer) {
            // value is a container; return pages in it
            $pages = [];

            foreach ($mixed as $page) {
                $pages[] = $page;
            }

            return $pages;
        }

        if (is_string($mixed)) {
            // value is a string; make a URI page
            try {
                if (null !== $this->pageFactory) {
                    $page = $this->pageFactory->factory(
                        [
                            'type' => 'uri',
                            'uri' => $mixed,
                        ]
                    );
                } else {
                    $page = AbstractPage::factory(
                        [
                            'type' => 'uri',
                            'uri' => $mixed,
                        ]
                    );
                }

                return [$page];
            } catch (InvalidArgumentException | \Laminas\Navigation\Exception\InvalidArgumentException $e) {
                $this->logger->err($e);

                return [];
            }
        }

        if ($mixed instanceof Traversable) {
            $mixed = ArrayUtils::iteratorToArray($mixed);
        }

        if (is_array($mixed) && [] !== $mixed) {
            if ($recursive && is_numeric(key($mixed))) {
                // first key is numeric; assume several pages
                return array_map(
                    /**
                     * @return AbstractPage|PageInterface
                     */
                    function ($value) {
                        [$page] = $this->convert($value, false);

                        return $page;
                    },
                    $mixed
                );
            }

            // pass array to factory directly
            try {
                if (null !== $this->pageFactory) {
                    $page = $this->pageFactory->factory($mixed);
                } else {
                    $page = AbstractPage::factory($mixed);
                }

                return [$page];
            } catch (InvalidArgumentException | \Laminas\Navigation\Exception\InvalidArgumentException $e) {
                $this->logger->err($e);
            }
        }

        // nothing found
        return [];
    }
}
