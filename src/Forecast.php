<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:20 PM
 */
namespace VertigoLabs\Overcast;

use VertigoLabs\Overcast\ValueObjects\Alert;
use VertigoLabs\Overcast\ValueObjects\DataBlock;
use VertigoLabs\Overcast\ValueObjects\DataPoint;

/**
 * Class Forecast
 *
 * The Forecast class represents the data returned
 * from the Dark Sky API
 *
 * @package VertigoLabs\Overcast
 */
class Forecast
{
    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var \DateTimeZone
     */
    private $timezone;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var DataPoint
     */
    private $currently;
    /**
     * @var DataBlock
     */
    private $minutely;
    /**
     * @var DataBlock
     */
    private $hourly;
    /**
     * @var DataBlock
     */
    private $daily;
    /**
     * @var Alert[]
     */
    private $alerts;

    /**
     * @var int
     */
    private $cacheTTL;
    /**
     * @var null
     */
    private $responseTime;

    /**
     * @param array $forecastData
     * @param int|null $cacheTTL
     * @param int|null $responseTime
     */
    public function __construct($forecastData, $cacheTTL = null, $responseTime = null)
    {
        if (isset($forecastData['latitude'])) {
            $this->latitude = $forecastData['latitude'];
        }
        if (isset($forecastData['longitude'])) {
            $this->longitude = $forecastData['longitude'];
        }
        if (isset($forecastData['timezone'])) {
            $this->timezone = new \DateTimeZone($forecastData['timezone']);
        }
        if (isset($forecastData['offset'])) {
            $this->offset = $forecastData['offset'];
        }
        if (isset($forecastData['currently'])) {
            $this->currently = new DataPoint($forecastData['currently']);
        }
        if (isset($forecastData['minutely'])) {
            $this->minutely = new DataBlock($forecastData['minutely']);
        }
        if (isset($forecastData['hourly'])) {
            $this->hourly = new DataBlock($forecastData['hourly']);
        }
        if (isset($forecastData['daily'])) {
            $this->daily = new DataBlock($forecastData['daily']);
        }
        if (isset($forecastData['alerts'])) {
            foreach ($forecastData['alerts'] as $alert) {
                $this->alerts[] = new Alert($alert);
            }
        }
        $this->cacheTTL = $cacheTTL;
        $this->responseTime = $responseTime;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return DataPoint
     */
    public function getCurrently()
    {
        return $this->currently;
    }

    /**
     * @return DataBlock
     */
    public function getMinutely()
    {
        return $this->minutely;
    }

    /**
     * @return DataBlock
     */
    public function getHourly()
    {
        return $this->hourly;
    }

    /**
     * @return DataBlock
     */
    public function getDaily()
    {
        return $this->daily;
    }

    /**
     * @return ValueObjects\Alert[]
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @return int|null
     */
    public function getCacheTTL()
    {
        return $this->cacheTTL;
    }

    /**
     * @return int|null
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }
}
