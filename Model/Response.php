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
 * Google Analytics Response.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Response
{
    /** @var array */
    protected $profileInfo;

    /** @var string */
    protected $kind;

    /** @var string */
    protected $id;

    /** @var array */
    protected $query;

    /** @var string */
    protected $selfLink;

    /** @var string */
    protected $previousLink;

    /** @var string */
    protected $nextLink;

    /** @var integer */
    protected $startIndex;

    /** @var integer */
    protected $itemsPerPage;

    /** @var integer */
    protected $totalResults;

    /** @var boolean */
    protected $containsSampledData;

    /** @var array */
    protected $columnHeaders;

    /** @var array */
    protected $totalsForAllResults;

    /** @var array */
    protected $rows;

    /**
     * The google analytics response constructor.
     *
     * @param array $response The google analytics response.
     */
    public function __construct(array $response)
    {
        $this->profileInfo = array();
        if (isset($response['profileInfo'])) {
            $this->profileInfo = $response['profileInfo'];
        }

        if (isset($response['kind'])) {
            $this->kind = $response['kind'];
        }

        if (isset($response['id'])) {
            $this->id = $response['id'];
        }

        $this->query = array();
        if (isset($response['query'])) {
            $this->query = $response['query'];
        }

        if (isset($response['selfLink'])) {
            $this->selfLink = $response['selfLink'];
        }

        if (isset($response['previousLink'])) {
            $this->previousLink = $response['previousLink'];
        }

        if (isset($response['nextLink'])) {
            $this->nextLink = $response['nextLink'];
        }

        if (isset($response['startIndex'])) {
            $this->startIndex = $response['startIndex'];
        }

        if (isset($response['itemsPerPage'])) {
            $this->itemsPerPage = $response['itemsPerPage'];
        }

        if (isset($response['totalResults'])) {
            $this->totalResults = $response['totalResults'];
        }

        if (isset($response['containsSampledData'])) {
            $this->containsSampledData = $response['containsSampledData'];
        }

        $this->columnHeaders = array();
        if (isset($response['columnHeaders'])) {
            $this->columnHeaders = $response['columnHeaders'];
        }

        $this->totalsForAllResults = array();
        if (isset($response['totalsForAllResults'])) {
            $this->totalsForAllResults = $response['totalsForAllResults'];
        }

        $this->rows = array();
        if (isset($response['rows'])) {
            $this->rows = $response['rows'];
        }
    }

    /**
     * Gets the profile info.
     *
     * The available informations are:
     *  - profileId: Profile ID, such as 1174.
     *  - accountId: Account ID to which this profile belongs, such as 30481.
     *  - webPropertyId: Web Property ID to which this profile belongs, such as UA-30481-1.
     *  - internalWebPropertyId: Internal ID for the web property to which this profile belongs, such as UA-30481-1.
     *  - profileName: Name of the profile.
     *  - tableId: Table ID for profile, consisting of "ga:" followed by the profile ID.
     *
     * @return array The profile info.
     */
    public function getProfileInfo()
    {
        return $this->profileInfo;
    }

    /**
     * Gets the resource type (value is "analytics#gaData").
     *
     * @return string The resource type.
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Gets the ID for this data response.
     *
     * @return string The ID for this data response.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the initial query.
     *
     * The available informations are:
     *  - start-date: Start date.
     *  - end-date: End date.
     *  - ids: Unique table ID.
     *  - dimensions: List of analytics dimensions.
     *  - metrics: List of analytics metrics.
     *  - sort: List of metrics or dimensions on which the data is sorted.
     *  - filters: Comma-separated list of metric or dimension filters.
     *  - segment: Analytics advanced segment.
     *  - start-index: Start index.
     *  - max-results: Maximum results per page.
     *
     * @return array The intiail query.
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets the self link.
     *
     * @return string The self link.
     */
    public function getSelfLink()
    {
        return $this->selfLink;
    }

    /**
     * Gets the previous link.
     *
     * @return string The previous link.
     */
    public function getPreviousLink()
    {
        return $this->previousLink;
    }

    /**
     * Gets the next link.
     *
     * @return string The next link.
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * Gets the start index.
     *
     * @return integer The start index.
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * Gets the number of items per page.
     *
     * @return integer The number of items per page.
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Gets the total number of results.
     *
     * @return integer The total number of results.
     */
    public function getTotalResults()
    {
        return $this->totalResults;
    }

    /**
     * Checks if the response contains sampled data.
     *
     * @return boolean TRUE if the response contains sampled data else FALSE.
     */
    public function containsSampledData()
    {
        return $this->containsSampledData;
    }

    /**
     * Gets the column headers.
     *
     * The availbale informations are:
     *  - name: Name of the dimension or metric.
     *  - columnType: Column type.
     *  - dataType: Data type.
     *
     * @return array The column headers.
     */
    public function getColumnHeaders()
    {
        return $this->columnHeaders;
    }

    /**
     * Gets the totals for all results.
     *
     * @return array The totals for all results.
     */
    public function getTotalsForAllResults()
    {
        return $this->totalsForAllResults;
    }

    /**
     * Checks if the response has rows.
     *
     * @return boolean TRUE if the respone has rows else FALSE.
     */
    public function hasRows()
    {
        return !empty($this->rows);
    }

    /**
     * Gets the rows.
     *
     * @return array The rows.
     */
    public function getRows()
    {
        return $this->rows;
    }
}
