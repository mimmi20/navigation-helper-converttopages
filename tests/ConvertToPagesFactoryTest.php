<?php
/**
 * This file is part of the mimmi20/navigation-helper-converttopages package.
 *
 * Copyright (c) 2021-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\NavigationHelper\ConvertToPages;

use Mimmi20\Mezzio\Navigation\Page\PageFactoryInterface;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPages;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPagesFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function assert;

final class ConvertToPagesFactoryTest extends TestCase
{
    private ConvertToPagesFactory $factory;

    /** @throws void */
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
        $logger = $this->createMock(LoggerInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(LoggerInterface::class)
            ->willReturn($logger);
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
        $logger      = $this->createMock(LoggerInterface::class);
        $pageFactory = $this->createMock(PageFactoryInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher   = self::exactly(2);
        $container->expects($matcher)
            ->method('get')
            ->willReturnCallback(
                static function (string $id) use ($matcher, $pageFactory, $logger): mixed {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(PageFactoryInterface::class, $id),
                        default => self::assertSame(LoggerInterface::class, $id),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $pageFactory,
                        default => $logger,
                    };
                },
            );
        $container->expects(self::once())
            ->method('has')
            ->with(PageFactoryInterface::class)
            ->willReturn(true);

        assert($container instanceof ContainerInterface);
        $helper = ($this->factory)($container);

        self::assertInstanceOf(ConvertToPages::class, $helper);
    }
}
