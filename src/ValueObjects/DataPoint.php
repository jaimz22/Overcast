<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:24 PM
 */

namespace VertigoLabs\Overcast\ValueObjects;


class DataPoint
{
    /**
     * @var \DateTime
     */
    private $time;
    /**
     * @var string
     */
    private $summary;
    /**
     * @var string
     */
    private $icon;
    /**
     * @var \DateTime
     */
    private $sunriseTime;
    /**
     * @var \DateTime
     */
    private $sunsetTime;
    /**
     * @var float
     */
    private $moonPhase;
    /**
     * @var int
     */
    private $nearestStormDistance;
    /**
     * @var int
     */
    private $nearestStormBearing;
    /**
     * @var Precipitation
     */
    private $precipitation;
    /**
     * @var Temperature
     */
    private $temperature;
    /**
     * @var Temperature
     */
    private $apparentTemperature;
    /**
     * @var float
     */
    private $dewPoint;
    /**
     * @var float
     */
    private $windSpeed;
    /**
     * @var int
     */
    private $windBearing;
    /**
     * @var float
     */
    private $cloudCover;
    /**
     * @var float
     */
    private $humidity;
    /**
     * @var float
     */
    private $pressure;
    /**
     * @var float
     */
    private $visibility;
    /**
     * @var float
     */
    private $ozone;

    public function __construct($data)
    {
        if (isset($data['time'])) {
            $this->time = (new \DateTime())->setTimestamp($data['time']);
        }
        if (isset($data['summary'])) {
            $this->summary = $data['summary'];
        }
        if (isset($data['icon'])) {
            $this->icon = $data['icon'];
        }
        if (isset($data['sunriseTime'])) {
            $this->sunriseTime = (new \DateTime())->setTimestamp($data['sunriseTime']);
        }
        if (isset($data['sunsetTime'])) {
            $this->sunsetTime = (new \DateTime())->setTimestamp($data['sunsetTime']);
        }
        if (isset($data['moonPhase'])) {
            $this->moonPhase = $data['moonPhase'];
        }
        if (isset($data['nearestStormDistance'])) {
            $this->nearestStormDistance = $data['nearestStormDistance'];
        }
        if (isset($data['nearestStormBearing'])) {
            $this->nearestStormBearing = $data['nearestStormBearing'];
        }

        $this->precipitation = new Precipitation(
            (isset($data['precipIntensity']) ? $data['precipIntensity'] : null),
            (isset($data['precipIntensityMax']) ? $data['precipIntensityMax'] : null),
            (isset($data['precipIntensityMaxTime']) ? $data['precipIntensityMaxTime'] : null),
            (isset($data['precipProbability']) ? $data['precipProbability'] : null),
            (isset($data['precipType']) ? $data['precipType'] : null),
            (isset($data['precipAccumulation']) ? $data['precipAccumulation'] : null)
        );
        $this->temperature = new Temperature(
            (isset($data['temperature']) ? $data['temperature'] : null),
            (isset($data['temperatureMin']) ? $data['temperatureMin'] : null),
            (isset($data['temperatureMinTime']) ? $data['temperatureMinTime'] : null),
            (isset($data['temperatureMax']) ? $data['temperatureMax'] : null),
            (isset($data['temperatureMaxTime']) ? $data['temperatureMaxTime'] : null)
        );
        $this->apparentTemperature = new Temperature(
            (isset($data['apparentTemperature']) ? $data['apparentTemperature'] : null),
            (isset($data['apparentTemperatureMin']) ? $data['apparentTemperatureMin'] : null),
            (isset($data['apparentTemperatureMinTime']) ? $data['apparentTemperatureMinTime'] : null),
            (isset($data['apparentTemperatureMax']) ? $data['apparentTemperatureMax'] : null),
            (isset($data['apparentTemperatureMaxTime']) ? $data['apparentTemperatureMaxTime'] : null)
        );

        if (isset($data['dewPoint'])) {
            $this->dewPoint = $data['dewPoint'];
        }
        if (isset($data['windSpeed'])) {
            $this->windSpeed = $data['windSpeed'];
        }
        if (isset($data['windBearing'])) {
            $this->windBearing = $data['windBearing'];
        }
        if (isset($data['cloudCover'])) {
            $this->cloudCover = $data['cloudCover'];
        }
        if (isset($data['humidity'])) {
            $this->humidity = $data['humidity'];
        }
        if (isset($data['pressure'])) {
            $this->pressure = $data['pressure'];
        }
        if (isset($data['visibility'])) {
            $this->visibility = $data['visibility'];
        }
        if (isset($data['ozone'])) {
            $this->ozone = $data['ozone'];
        }
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return \DateTime
     */
    public function getSunriseTime()
    {
        return $this->sunriseTime;
    }

    /**
     * @return \DateTime
     */
    public function getSunsetTime()
    {
        return $this->sunsetTime;
    }

    /**
     * @return float
     */
    public function getMoonPhase()
    {
        return $this->moonPhase;
    }

    /**
     * @return int
     */
    public function getNearestStormDistance()
    {
        return $this->nearestStormDistance;
    }

    /**
     * @return int
     */
    public function getNearestStormBearing()
    {
        return $this->nearestStormBearing;
    }

    /**
     * @return Precipitation
     */
    public function getPrecipitation()
    {
        return $this->precipitation;
    }

    /**
     * @return Temperature
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @return Temperature
     */
    public function getApparentTemperature()
    {
        return $this->apparentTemperature;
    }

    /**
     * @return float
     */
    public function getDewPoint()
    {
        return $this->dewPoint;
    }

    /**
     * @return float
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * @return int
     */
    public function getWindBearing()
    {
        return $this->windBearing;
    }

    /**
     * @return float
     */
    public function getCloudCover()
    {
        return $this->cloudCover;
    }

    /**
     * @return float
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @return float
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * @return float
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return float
     */
    public function getOzone()
    {
        return $this->ozone;
    }
}
