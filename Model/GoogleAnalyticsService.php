<?php

/*
 * This file is part of the Widop package.
 *
 * (c) Widop <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Model;

/**
 * Google Analytics service.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GoogleAnalyticsService
{
    /**
     * @var \Widop\GoogleAnalyticsBundle\Model\Client The google analytics client.
     */
    private $client;

    /**
     * Google analytics service constructor.
     *
     * @param \Widop\GoogleAnalyticsBundle\Model\Client $client The google analytics client.
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Gets the google analytics client.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets the google analytics client.
     *
     * @param \Widop\GoogleAnalyticsBundle\Model\Client $client The google analytics client.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\GoogleAnalyticsService
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Query the google analytics service.
     *
     * @param \Widop\GoogleAnalyticsBundle\Model\Query $query The google analytics query.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Response The google analytics response.
     */
    public function query(Query $query)
    {
        $uri = $query->build($this->getClient()->getAccessToken());
        $json = json_decode($this->getClient()->getHttpAdapter()->getContent($uri));

        $response = new Response();

        if (isset($json->rows)) {
            $response->setRows($json->rows);
        }

        return $response;
    }
}
