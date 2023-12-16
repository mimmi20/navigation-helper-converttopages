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

use Laminas\Config\Config;
use Laminas\Navigation\Page\AbstractPage;
use Mezzio\Navigation\Exception\InvalidArgumentException;
use Mezzio\Navigation\Navigation;
use Mezzio\Navigation\Page\PageFactoryInterface;
use Mezzio\Navigation\Page\PageInterface;
use Mezzio\Navigation\Page\Uri;
use Mimmi20\NavigationHelper\ConvertToPages\ConvertToPages;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class ConvertToPagesTest extends TestCase
{
    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromPage(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::never())
            ->method('factory');

        $helper = new ConvertToPages($logger, $pageFactory);

        $page = $this->createMock(PageInterface::class);

        self::assertSame([$page], $helper->convert($page));
        self::assertSame([$page], $helper->convert($page, true));
        self::assertSame([$page], $helper->convert($page, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromPage2(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $helper = new ConvertToPages($logger, null);

        $page = $this->createMock(AbstractPage::class);

        self::assertSame([$page], $helper->convert($page));
        self::assertSame([$page], $helper->convert($page, true));
        self::assertSame([$page], $helper->convert($page, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function testConvertFromContainer(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::never())
            ->method('factory');

        $helper = new ConvertToPages($logger, $pageFactory);

        $page1 = new Uri();
        $page2 = new Uri();

        $container = new Navigation();
        $container->addPage($page1);
        $container->addPage($page2);

        self::assertSame([$page1, $page2], $helper->convert($container));
        self::assertSame([$page1, $page2], $helper->convert($container, true));
        self::assertSame([$page1, $page2], $helper->convert($container, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testConvertFromContainer2(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $helper = new ConvertToPages($logger, null);

        $page1 = new \Laminas\Navigation\Page\Uri();
        $page2 = new \Laminas\Navigation\Page\Uri();

        $container = new \Laminas\Navigation\Navigation();
        $container->addPage($page1);
        $container->addPage($page2);

        self::assertSame([$page1, $page2], $helper->convert($container));
        self::assertSame([$page1, $page2], $helper->convert($container, true));
        self::assertSame([$page1, $page2], $helper->convert($container, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromString(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri  = 'test-uri';
        $page = $this->createMock(PageInterface::class);

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with(
                [
                    'type' => 'uri',
                    'uri' => $uri,
                ],
            )
            ->willReturn($page);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([$page], $helper->convert($uri));
        self::assertSame([$page], $helper->convert($uri, true));
        self::assertSame([$page], $helper->convert($uri, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromStringWithException(): void
    {
        $exception = new InvalidArgumentException('test');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::exactly(3))
            ->method('error')
            ->with($exception);
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri = 'test-uri';

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with(
                [
                    'type' => 'uri',
                    'uri' => $uri,
                ],
            )
            ->willThrowException($exception);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([], $helper->convert($uri));
        self::assertSame([], $helper->convert($uri, true));
        self::assertSame([], $helper->convert($uri, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromString2(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri    = 'test-uri';
        $helper = new ConvertToPages($logger, null);

        [$page] = $helper->convert($uri);

        self::assertInstanceOf(\Laminas\Navigation\Page\Uri::class, $page);
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromString3(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri = 'test-uri';

        $helper = new ConvertToPages($logger, null);

        [$page] = $helper->convert($uri);

        self::assertInstanceOf(\Laminas\Navigation\Page\Uri::class, $page);
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromConfig(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri  = 'test-uri';
        $page = $this->createMock(PageInterface::class);

        $configArray = [
            'type' => 'uri',
            'uri' => $uri,
        ];
        $config      = new Config($configArray);

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with($configArray)
            ->willReturn($page);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([$page], $helper->convert($config));
        self::assertSame([$page], $helper->convert($config, true));
        self::assertSame([$page], $helper->convert($config, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromConfigWithException(): void
    {
        $exception = new InvalidArgumentException('test');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::exactly(3))
            ->method('error')
            ->with($exception);
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri = 'test-uri';

        $configArray = [
            'type' => 'uri',
            'uri' => $uri,
        ];
        $config      = new Config($configArray);

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with($configArray)
            ->willThrowException($exception);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([], $helper->convert($config));
        self::assertSame([], $helper->convert($config, true));
        self::assertSame([], $helper->convert($config, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromInteger(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::never())
            ->method('factory');

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([], $helper->convert(1));
        self::assertSame([], $helper->convert(1, true));
        self::assertSame([], $helper->convert(1, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri  = 'test-uri';
        $page = $this->createMock(PageInterface::class);

        $config = [
            'type' => 'uri',
            'uri' => $uri,
        ];

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with($config)
            ->willReturn($page);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([$page], $helper->convert($config));
        self::assertSame([$page], $helper->convert($config, true));
        self::assertSame([$page], $helper->convert($config, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromArrayWithException(): void
    {
        $exception = new InvalidArgumentException('test');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::exactly(3))
            ->method('error')
            ->with($exception);
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri = 'test-uri';

        $config = [
            'type' => 'uri',
            'uri' => $uri,
        ];

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageFactory->expects(self::exactly(3))
            ->method('factory')
            ->with($config)
            ->willThrowException($exception);

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([], $helper->convert($config));
        self::assertSame([], $helper->convert($config, true));
        self::assertSame([], $helper->convert($config, false));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromArray2(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri  = 'test-uri';
        $page = $this->createMock(PageInterface::class);

        $config = [
            'type' => 'uri',
            'uri' => $uri,
        ];

        $helper = new ConvertToPages($logger, null);

        [$page] = $helper->convert($config);

        self::assertInstanceOf(\Laminas\Navigation\Page\Uri::class, $page);
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    public function testConvertFromArray3(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri = 'test-uri';

        $config = [
            'type' => 'uri',
            'uri' => $uri,
        ];

        $helper = new ConvertToPages($logger, null);

        [$page] = $helper->convert($config);

        self::assertInstanceOf(\Laminas\Navigation\Page\Uri::class, $page);
    }

    /**
     * @throws Exception
     * @throws \Laminas\Stdlib\Exception\InvalidArgumentException
     */
    #[Group('Convert')]
    public function testConvertFromRecursiveArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects(self::never())
            ->method('emergency');
        $logger->expects(self::never())
            ->method('alert');
        $logger->expects(self::never())
            ->method('critical');
        $logger->expects(self::never())
            ->method('error');
        $logger->expects(self::never())
            ->method('warning');
        $logger->expects(self::never())
            ->method('notice');
        $logger->expects(self::never())
            ->method('info');
        $logger->expects(self::never())
            ->method('debug');

        $uri1  = 'test-uri1';
        $uri2  = 'test-uri2';
        $page1 = $this->createMock(PageInterface::class);
        $page2 = $this->createMock(PageInterface::class);

        $config1 = [
            'type' => 'uri',
            'uri' => $uri1,
        ];
        $config2 = [
            'type' => 'uri',
            'uri' => $uri2,
        ];

        $config = [$config1, $config2];

        $pageFactory = $this->getMockBuilder(PageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher     = self::exactly(5);
        $pageFactory->expects($matcher)
            ->method('factory')
            ->willReturnCallback(
                static function (array $options) use ($matcher, $config1, $config2, $config, $page2, $page1): PageInterface {
                    match ($matcher->numberOfInvocations()) {
                        1, 3 => self::assertSame($config1, $options),
                        2, 4 => self::assertSame($config2, $options),
                        default => self::assertSame($config, $options),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        2,4 => $page2,
                        default => $page1,
                    };
                },
            );

        $helper = new ConvertToPages($logger, $pageFactory);

        self::assertSame([$page1, $page2], $helper->convert($config));
        self::assertSame([$page1, $page2], $helper->convert($config, true));
        self::assertSame([$page1], $helper->convert($config, false));
    }
}
