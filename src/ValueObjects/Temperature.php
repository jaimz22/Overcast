<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:28 PM
 */

namespace VertigoLabs\Overcast\ValueObjects;


class Temperature
{
    /**
     * @var Float
     */
    private $current;
    /**
     * @var Float
     */
    private $min;
    /**
     * @var \DateTime
     */
    private $minTime;
    /**
     * @var Float
     */
    private $max;
    /**
     * @var \DateTime
     */
    private $maxTime;

    public function __construct($current, $min, $minTime, $max, $maxTime)
    {
        $this->current = $current;
        $this->min = $min;
        if (!is_null($minTime)) {
            $this->minTime = (new \DateTime())->setTimestamp($minTime);
        }
        $this->max = $max;
        if (!is_null($maxTime)) {
            $this->maxTime = (new \DateTime())->setTimestamp($maxTime);
        }
    }

    /**
     * @return Float
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return Float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return \DateTime
     */
    public function getMinTime()
    {
        return $this->minTime;
    }

    /**
     * @return Float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return \DateTime
     */
    public function getMaxTime()
    {
        return $this->maxTime;
    }
}
