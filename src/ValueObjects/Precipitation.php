<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:27 PM
 */

namespace VertigoLabs\Overcast\ValueObjects;


class Precipitation
{
    /**
     * @var float
     */
    private $intensity;
    /**
     * @var float
     */
    private $maxIntensity;
    /**
     * @var \DateTime
     */
    private $maxIntensityTime;
    /**
     * @var float
     */
    private $probability;
    /**
     * @var string
     */
    private $type;
    /**
     * @var float
     */
    private $accumulation;

    public function __construct($intensity, $maxIntensity, $maxIntensityTime, $probability, $type, $accumulation)
    {
        $this->intensity = $intensity;
        $this->maxIntensity = $maxIntensity;
        if (!is_null($maxIntensityTime)) {
            $this->maxIntensityTime = (new \DateTime())->setTimestamp($maxIntensityTime);
        }
        $this->probability = $probability;
        $this->type = $type;
        $this->accumulation = $accumulation;
    }

    /**
     * @return float
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * @return float
     */
    public function getMaxIntensity()
    {
        return $this->maxIntensity;
    }

    /**
     * @return \DateTime
     */
    public function getMaxIntensityTime()
    {
        return $this->maxIntensityTime;
    }

    /**
     * @return float
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getAccumulation()
    {
        return $this->accumulation;
    }
}
