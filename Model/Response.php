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
    protected $rows;

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
     * Checks if the response has rows.
     *
     * @return boolean TRUE if the respone has rows else FALSE.
     */
    public function hasRows()
    {
        return !empty($this->rows);
    }

    /**
     * Gets the google analytics response rows.
     *
     * @return array The google analytics response rows.
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Sets the google analytics response rows.
     *
     * @param array $rows The google analytics response rows.
     */
    public function setRows(array $rows)
    {
        $this->rows = array();

        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }

    /**
     * Adds a rown to the google analytics response.
     *
     * @param array $row The row to add.
     */
    public function addRow(array $row)
    {
        $this->rows[] = $row;
    }
}
