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
 * Google Analytics Response.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Response
{
    /**
     * @var array The google analytics response rows.
     */
    private $rows;

    /**
     * The google analytics response constructor.
     *
     * @param array $rows The google analytics response rows.
     */
    public function __construct(array $rows = array())
    {
        $this->setRows($rows);
    }

    /**
     * Gets the google analytics response rows.
     *
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Sets the google analytics response rows.
     *
     * @param array $rows The google analytics response rows.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Response
     */
    public function setRows(array $rows)
    {
        $this->rows = array();

        foreach ($rows as $row) {
            $this->addRow($row);
        }

        return $this;
    }

    /**
     * Adds a rown to the google analytics response.
     *
     * @param array $row The row to add.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Response
     */
    public function addRow(array $row)
    {
        $this->rows[] = $row;

        return $this;
    }
}
