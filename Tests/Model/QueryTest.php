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

use Widop\GoogleAnalyticsBundle\Model\Query;

/**
 * Google analytics query test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GoogleAnalyticsBundle\Model\Query */
    protected $query;

    /** @var string */
    protected $ids;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->ids = 'ids';
        $this->query = new Query($this->ids);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->query);
        unset($this->ids);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->ids, $this->query->getIds());
        $this->assertFalse($this->query->hasStartDate());
        $this->assertFalse($this->query->hasEndDate());
        $this->assertFalse($this->query->hasMetrics());
        $this->assertFalse($this->query->hasDimensions());
        $this->assertFalse($this->query->hasSorts());
        $this->assertFalse($this->query->hasFilters());
        $this->assertFalse($this->query->hasSegment());
        $this->assertSame(1, $this->query->getStartIndex());
        $this->assertSame(1000, $this->query->getMaxResults());
        $this->assertFalse($this->query->getPrettyPrint());
        $this->assertFalse($this->query->hasCallback());
    }

    public function testIds()
    {
        $this->query->setIds('foo');

        $this->assertSame('foo', $this->query->getIds());
    }

    public function testStartDate()
    {
        $startDate = new \DateTime();
        $this->query->setStartDate($startDate);

        $this->assertSame($startDate, $this->query->getStartDate());
    }

    public function testEndDate()
    {
        $endDate = new \DateTime();
        $this->query->setEndDate($endDate);

        $this->assertSame($endDate, $this->query->getEndDate());
    }

    public function testMetrics()
    {
        $metrics = array('foo', 'bar');
        $this->query->setMetrics($metrics);

        $this->assertTrue($this->query->hasMetrics());
        $this->assertSame($metrics, $this->query->getMetrics());
    }

    public function testDimensions()
    {
        $dimensions = array('foo', 'bar');
        $this->query->setDimensions($dimensions);

        $this->assertTrue($this->query->hasDimensions());
        $this->assertSame($dimensions, $this->query->getDimensions());
    }

    public function testSorts()
    {
        $sorts = array('foo', 'bar');
        $this->query->setSorts($sorts);

        $this->assertTrue($this->query->hasSorts());
        $this->assertSame($sorts, $this->query->getSorts());
    }

    public function testFilters()
    {
        $filters = array('foo', 'bar');
        $this->query->setFilters($filters);

        $this->assertTrue($this->query->hasFilters());
        $this->assertSame($filters, $this->query->getFilters());
    }

    public function testSegment()
    {
        $segment = 'foo';
        $this->query->setSegment($segment);

        $this->assertTrue($this->query->hasSegment());
        $this->assertSame($segment, $this->query->getSegment());
    }

    public function testStartIndex()
    {
        $startIndex = 3;
        $this->query->setStartIndex($startIndex);

        $this->assertSame($startIndex, $this->query->getStartIndex());
    }

    public function testMaxResults()
    {
        $maxResults = 100;
        $this->query->setMaxResults($maxResults);

        $this->assertSame($maxResults, $this->query->getMaxResults());
    }

    public function testPrettyPrint()
    {
        $this->query->setPrettyPrint(true);

        $this->assertTrue($this->query->getPrettyPrint());
    }

    public function testCallback()
    {
        $callback = 'foo';
        $this->query->setCallback($callback);

        $this->assertTrue($this->query->hasCallback());
        $this->assertSame($callback, $this->query->getCallback());
    }

    public function testBuild()
    {
        $this->query->setIds($ids = 'ids');
        $this->query->setStartDate($startDate = new \DateTime('2013-01-01'));
        $this->query->setEndDate($endDate = new \DateTime('2013-01-31'));
        $this->query->setMetrics($metrics = array('m1', 'm2'));
        $this->query->setDimensions($dimensions = array('d1', 'd2'));
        $this->query->setSorts(array('s1', 's2'));
        $this->query->setFilters(array('f1', 'f2'));
        $this->query->setSegment('seg');
        $this->query->setStartIndex(10);
        $this->query->setMaxResults(100);
        $this->query->setPrettyPrint(true);
        $this->query->setCallback('call');

        $expected = 'https://www.googleapis.com/analytics/v3/data/ga?ids=ids&metrics=m1%2Cm2&start-date=2013-01-01&'.
            'end-date=2013-01-31&access_token=token&start-index=10&max-results=100&segment=seg&dimensions=d1%2Cd2&'.
            'filters=f1%2Cf2&sort=s1%2Cs2&prettyPrint=true&callback=call';

        $this->assertSame($expected, $this->query->build('token'));
    }
}
