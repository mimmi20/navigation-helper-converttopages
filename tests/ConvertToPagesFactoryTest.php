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

namespace Mimmi20Test\NavigationHelper\ConvertToPages;

use Mimmi20\Mezzio\Navigation\Page\PageFactoryInterface;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPages;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPagesFactory;
use Override;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class ConvertToPagesFactoryTest extends TestCase
{
    private ConvertToPagesFactory $factory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->factory = new ConvertToPagesFactory();
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvocation(): void
    {
        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('get');
        $container->expects(self::once())
            ->method('has')
            ->with(PageFactoryInterface::class)
            ->willReturn(false);

        assert($container instanceof ContainerInterface);
        $helper = ($this->factory)($container);

        self::assertInstanceOf(ConvertToPages::class, $helper);
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvocation2(): void
    {
        $pageFactory = $this->createMock(PageFactoryInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(PageFactoryInterface::class)
            ->willReturn($pageFactory);
        $container->expects(self::once())
            ->method('has')
            ->with(PageFactoryInterface::class)
            ->willReturn(true);

        assert($container instanceof ContainerInterface);
        $helper = ($this->factory)($container);

        self::assertInstanceOf(ConvertToPages::class, $helper);
    }
}
