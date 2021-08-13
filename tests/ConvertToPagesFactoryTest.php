<?php
/**
 * This file is part of the mimmi20/navigation-helper-converttopages package.
 *
 * Copyright (c) 2020-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\NavigationHelper\ConvertToPages;

use Interop\Container\ContainerInterface;
use Laminas\Log\Logger;
use Mezzio\Navigation\Page\PageFactoryInterface;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPages;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPagesFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

use function assert;

final class ConvertToPagesFactoryTest extends TestCase
{
    private ConvertToPagesFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ConvertToPagesFactory();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvocation(): void
    {
        $logger = $this->createMock(Logger::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(Logger::class)
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
     * @throws InvalidArgumentException
     */
    public function testInvocation2(): void
    {
        $logger      = $this->createMock(Logger::class);
        $pageFactory = $this->createMock(PageFactoryInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive([PageFactoryInterface::class], [Logger::class])
            ->willReturnOnConsecutiveCalls($pageFactory, $logger);
        $container->expects(self::once())
            ->method('has')
            ->with(PageFactoryInterface::class)
            ->willReturn(true);

        assert($container instanceof ContainerInterface);
        $helper = ($this->factory)($container);

        self::assertInstanceOf(ConvertToPages::class, $helper);
    }
}
