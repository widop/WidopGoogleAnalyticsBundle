<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Tests\Model;

use Widop\GoogleAnalyticsBundle\Model\Response;

/**
 * Google analytics reponse test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GoogleAnalyticsBundle\Model\Response */
    protected $response;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->response = new Response();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->response);
    }

    public function testDefaultState()
    {
        $this->assertFalse($this->response->hasRows());
    }

    public function testInitialState()
    {
        $rows = array(array('foo' => 'bar'));
        $this->response = new Response($rows);

        $this->assertTrue($this->response->hasRows());
        $this->assertSame($rows, $this->response->getRows());
    }
}
