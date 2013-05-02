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

use Widop\GoogleAnalyticsBundle\Model\GoogleAnalyticsService;

/**
 * Wid'op google analytics service test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GoogleAnalyticsServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GoogleAnalyticsBundle\Model\GoogleAnalyticsService */
    protected $service;

    /** @var \Widop\GoogleAnalyticsBundle\Model\Client */
    protected $clientMock;

    /** @var \Widop\HttpAdapterBundle\Model\HttpAdapterInterface */
    protected $httpAdapterMock;

    /** @var \Widop\GoogleAnalyticsBundle\Model\Query */
    protected $queryMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->httpAdapterMock = $this->getMock('Widop\HttpAdapterBundle\Model\HttpAdapterInterface');

        $this->clientMock = $this->getMockBuilder('Widop\GoogleAnalyticsBundle\Model\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock
            ->expects($this->any())
            ->method('getHttpAdapter')
            ->will($this->returnValue($this->httpAdapterMock));

        $this->service = new GoogleAnalyticsService($this->clientMock);

        $this->queryMock = $this->getMockBuilder('Widop\GoogleAnalyticsBundle\Model\Query')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->service);
        unset($this->clientMock);
        unset($this->queryMock);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->clientMock, $this->service->getClient());
    }

    public function testQuery()
    {
        $this->clientMock
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue('token'));

        $this->queryMock
            ->expects($this->once())
            ->method('build')
            ->with($this->equalTo('token'))
            ->will($this->returnValue('uri'));

        $expected = array(
            'profileInfo'         => array('profile' => 'bar'),
            'kind'                => 'kind',
            'id'                  => 'id',
            'query'               => array('query' => 'bar'),
            'selfLink'            => 'selfLink',
            'previousLink'        => 'previousLink',
            'nextLink'            => 'nextLink',
            'startIndex'          => 1,
            'itemsPerPage'        => 10000,
            'totalResults'        => 10000,
            'containsSampledData' => false,
            'columnHeaders'       => array('column' => 'bar'),
            'totalsForAllResults' => array('total' => 'bar'),
            'rows'                => array('row' => 'bar'),
        );

        $this->httpAdapterMock
            ->expects($this->once())
            ->method('getContent')
            ->with($this->equalTo('uri'))
            ->will($this->returnValue(json_encode($expected)));

        $response = $this->service->query($this->queryMock);

        $this->assertSame($expected['profileInfo'], $response->getProfileInfo());
        $this->assertSame($expected['kind'], $response->getKind());
        $this->assertSame($expected['id'], $response->getId());
        $this->assertSame($expected['query'], $response->getQuery());
        $this->assertSame($expected['selfLink'], $response->getSelfLink());
        $this->assertSame($expected['previousLink'], $response->getPreviousLink());
        $this->assertSame($expected['nextLink'], $response->getNextLink());
        $this->assertSame($expected['startIndex'], $response->getStartIndex());
        $this->assertSame($expected['itemsPerPage'], $response->getItemsPerPage());
        $this->assertSame($expected['totalResults'], $response->getTotalResults());
        $this->assertSame($expected['containsSampledData'], $response->containsSampledData());
        $this->assertSame($expected['columnHeaders'], $response->getColumnHeaders());
        $this->assertSame($expected['totalsForAllResults'], $response->getTotalsForAllResults());
        $this->assertTrue($response->hasRows());
        $this->assertSame($expected['rows'], $response->getRows());
    }

    /**
     * @expectedException \Exception
     */
    public function testQueryError()
    {
        $this->clientMock
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue('token'));

        $this->queryMock
            ->expects($this->once())
            ->method('build')
            ->with($this->equalTo('token'))
            ->will($this->returnValue('uri'));

        $this->httpAdapterMock
            ->expects($this->once())
            ->method('getContent')
            ->with($this->equalTo('uri'))
            ->will($this->returnValue(json_encode(array('error' => array('message' => 'error')))));

        $this->service->query($this->queryMock);
    }
}
