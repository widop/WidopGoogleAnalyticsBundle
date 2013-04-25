<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Tests;

use Widop\GoogleAnalyticsBundle\WidopGoogleAnalyticsBundle;

/**
 * Wid'op google analytics bundle test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class WidopGoogleAnalyticsBundleTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GoogleAnalyticsBundle\WidopGoogleAnalyticsBundle */
    protected $bundle;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bundle = new WidopGoogleAnalyticsBundle();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->bundle);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\Bundle\Bundle', $this->bundle);
    }
}
