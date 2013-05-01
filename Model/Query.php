<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Model;

/**
 * Google Analytics Query.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Query
{
    /** @const The Google analytics service URL. */
    const URL = 'https://www.googleapis.com/analytics/v3/data/ga';

    /** @var string */
    protected $ids;

    /** @var \DateTime */
    protected $startDate;

    /** @var \DateTime */
    protected $endDate;

    /** @var array */
    protected $metrics;

    /** @var array */
    protected $dimensions;

    /** @var array */
    protected $sorts;

    /** @var array */
    protected $filters;

    /** @var string */
    protected $segment;

    /** @var integer */
    protected $startIndex;

    /** @var integer */
    protected $maxResults;

    /** @var boolean */
    protected $prettyPrint;

    /** @var string */
    protected $callback;

    /**
     * Creates a google analytics query.
     *
     * @param string $ids The google analytics query ids.
     */
    public function __construct($ids)
    {
        $this->setIds($ids);

        $this->metrics = array();
        $this->dimensions = array();
        $this->sorts = array();
        $this->filters = array();
        $this->startIndex = 1;
        $this->maxResults = 10000;
        $this->prettyPrint = false;
    }

    /**
     * Gets the google analytics query ids.
     *
     * @return string The google analytics query ids.
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Sets the google analytics query ids.
     *
     * @param string $ids The google analytics query ids.
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Checks if the google analytics query has a start date.
     *
     * @return boolean TRUE if the google analytics query has a start date.
     */
    public function hasStartDate()
    {
        return $this->startDate !== null;
    }

    /**
     * Gets the google analytics query start date.
     *
     * @return \DateTime The google analytics query start date.
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the google analytics query start date.
     *
     * @param \DateTime $startDate The google analytics query start date.
     */
    public function setStartDate(\DateTime $startDate = null)
    {
        $this->startDate = $startDate;
    }

    /**
     * Checks if the google analytics query has an end date.
     *
     * @return boolean TRUE if the google analytics query has an ende date else FALSE.
     */
    public function hasEndDate()
    {
        return $this->endDate !== null;
    }

    /**
     * Gets the google analytics query end date.
     *
     * @return \DateTime The google analytics query end date.
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Sets the google analytics query end date.
     *
     * @param \DateTime $endDate The google analytics query end date.
     */
    public function setEndDate(\DateTime $endDate = null)
    {
        $this->endDate = $endDate;
    }

    /**
     * Checks if the google analytics query has metrics.
     *
     * @return boolean TRUE if the google analytics query has metrics else FALSE.
     */
    public function hasMetrics()
    {
        return !empty($this->metrics);
    }

    /**
     * Gets the google analytics query metrics.
     *
     * @return array The google analytics query metrics.
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * Sets the google analytics query metrics.
     *
     * @param array $metrics The google analytics query metrics.
     */
    public function setMetrics(array $metrics)
    {
        $this->metrics = array();

        foreach ($metrics as $metric) {
            $this->addMetric($metric);
        }
    }

    /**
     * Adds a the google analytics metric to the query.
     *
     * @param string $metric The google analytics metric to add.
     */
    public function addMetric($metric)
    {
        $this->metrics[] = $metric;
    }

    /**
     * Checks if the google analytics query has dimensions.
     *
     * @return boolean TRUE if the google analytics query has a dimensions else FALSE.
     */
    public function hasDimensions()
    {
        return !empty($this->dimensions);
    }

    /**
     * Gets the google analytics query dimensions.
     *
     * @return array The google analytics query dimensions.
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Sets the google analytics query dimensions.
     *
     * @param array $dimensions The google analytics query dimensions.
     */
    public function setDimensions(array $dimensions)
    {
        $this->dimensions = array();

        foreach ($dimensions as $dimension) {
            $this->addDimension($dimension);
        }
    }

    /**
     * Adds a google analytics query dimension.
     *
     * @param string $dimension the google analytics dimension to add.
     */
    public function addDimension($dimension)
    {
        $this->dimensions[] = $dimension;
    }

    /**
     * Checks if the google analytics query is ordered.
     *
     * @return boolean TRUE if the google analytics query is ordered else FALSE.
     */
    public function hasSorts()
    {
        return !empty($this->sorts);
    }

    /**
     * Gets the google analytics query sorts.
     *
     * @return array The google analytics query sorts.
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * Sets the google analytics query sorts.
     *
     * @param array $sorts The google analytics query sorts.
     */
    public function setSorts(array $sorts)
    {
        $this->sorts = array();

        foreach ($sorts as $sort) {
            $this->addSort($sort);
        }
    }

    /**
     * Adds a google analytics query sort.
     *
     * @param string $sort A google analytics query sort to add.
     */
    public function addSort($sort)
    {
        $this->sorts[] = $sort;
    }

    /**
     * Checks if the google analytics query has filters.
     *
     * @return boolean TRUE if the google analytics query has filters else FALSE.
     */
    public function hasFilters()
    {
        return !empty($this->filters);
    }

    /**
     * Gets the google analytics query filters.
     *
     * @return array The google analytics query filters.
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Sets the google analytics query filters.
     *
     * @param array $filters The google analytics query filters.
     */
    public function setFilters(array $filters)
    {
        $this->filters = array();

        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * Adds the google analytics filter.
     *
     * @param string $filter the google analytics filter to add.
     */
    public function addFilter($filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Checks of the google analytics query has a segment.
     *
     * @return boolean TRUE if the google analytics query has a segment else FALSE.
     */
    public function hasSegment()
    {
        return $this->segment !== null;
    }

    /**
     * Gets the google analytics query segment.
     *
     * @return string The google analytics query segment.
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * Sets the google analytics query segment.
     *
     * @param string $segment The google analytics query segment.
     */
    public function setSegment($segment)
    {
        $this->segment = $segment;
    }

    /**
     * Gets the google analytics query start index.
     *
     * @return integer The google analytics query start index.
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * Sets the google analytics query start index.
     *
     * @param integer $startIndex The google analytics start index.
     */
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }

    /**
     * Gets the google analytics query max result count.
     *
     * @return integer The google analytics query max result count.
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * Sets the google analytics query max result count.
     *
     * @param integer $maxResults The google analytics query max result count.
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * Gets the google analytics query prettyPrint option.
     *
     * @return boolean The google analytics query prettyPrint option.
     */
    public function getPrettyPrint()
    {
        return $this->prettyPrint;
    }

    /**
     * Sets the google analytics query prettyPrint option.
     *
     * @param boolean $prettyPrint The google analytics query pretty print option.
     */
    public function setPrettyPrint($prettyPrint)
    {
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * Checks the google analytics query for a callback.
     *
     * @return boolean TRUE if the google analytics query has a callback else FALSE.
     */
    public function hasCallback()
    {
        return !empty($this->callback);
    }

    /**
     * Gets the google analytics query callback.
     *
     * @return string The google analytics query callback.
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Sets the google analytics query callback.
     *
     * @param string The google analytics query callback.
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Builds the query.
     *
     * @param string $accessToken The access token used to build the query.
     *
     * @return string The builded query.
     */
    public function build($accessToken)
    {
        $query = array(
            'ids'          => $this->getIds(),
            'metrics'      => implode(',', $this->getMetrics()),
            'start-date'   => $this->getStartDate()->format('Y-m-d'),
            'end-date'     => $this->getEndDate()->format('Y-m-d'),
            'access_token' => $accessToken,
            'start-index'  => $this->getStartIndex(),
            'max-results'  => $this->getMaxResults(),
        );

        if ($this->hasSegment()) {
            $query['segment'] = $this->getSegment();
        }

        if ($this->hasDimensions()) {
            $query['dimensions'] = implode(',', $this->getDimensions());
        }

        if ($this->hasFilters()) {
            $query['filters'] = implode(',', $this->getFilters());
        }

        if ($this->hasSorts()) {
            $query['sort'] = implode(',', $this->getSorts());
        }

        if ($this->getPrettyPrint()) {
            $query['prettyPrint'] = 'true';
        }

        if ($this->hasCallback()) {
            $query['callback'] = $this->getCallback();
        }

        return sprintf('%s?%s', self::URL, http_build_query($query));
    }
}
