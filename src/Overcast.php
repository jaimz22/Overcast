<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:17 PM
 *
 *
 * DISCLAIMER: This software is provided free of charge, and may be distributed.
 * It is not the fault of the author if this software causes damages, loss of data
 * loss of life, pregnant girlfriends, deep horrible depression, cupcakes, or good times
 * with friends.
 */
namespace VertigoLabs\Overcast;

use VertigoLabs\Overcast\ClientAdapters\FileGetContentsClientAdapter;
use VertigoLabs\Overcast\ClientAdapters\GuzzleClientAdapter;

/**
 * Class Overcast
 *
 * The Overcast class provides access to the Dark Sky API
 *
 * @package VertigoLabs\Overcast
 */
class Overcast
{
    const API_ENDPOINT = 'https://api.darksky.net/forecast/';

    /**
     * Private API Key
     * @var string
     */
    private static $apiKey;
    /**
     * The number of API calls made today
     * @var int
     */
    private $apiCalls = 0;
    /**
     * The adapter used to connect to the Dark Sky webservice.
     * @var ClientAdapterInterface
     */
    private $adapter;

    /**
     * Construct the Overcast class.
     *
     * You may optionally specify an adapter class which is used
     * to connect to the Dark Sky API. If no adapter is specified
     * a default will be chosen. If the Guzzle client is available the
     * GuzzleAdapter will be chosen, otherwise the FileGetContentsAdapter
     * will be used.
     *
     * @param string $apiKey
     * @param ClientAdapterInterface $adapter
     */
    public function __construct($apiKey, ClientAdapterInterface $adapter = null)
    {
        self::$apiKey = $apiKey;
        if (NULL === $adapter) {
            if (class_exists('GuzzleHttp\Client', true)) {
                $adapter = new GuzzleClientAdapter();
            } else {
                $adapter = new FileGetContentsClientAdapter();
            }
        }
        $this->adapter = $adapter;
    }

    /**
     * Retrieve the forecast for the specified latitude and longitude and
     * optionally the specified date and time.
     *
     * @param $latitude
     * @param $longitude
     * @param \DateTime $time
     * @param array $parameters
     *
     * @return Forecast
     */
    public function getForecast($latitude, $longitude, \DateTime $time = null, array $parameters = null)
    {
        try {
            $response = $this->adapter->getForecast($latitude, $longitude, $time, $parameters);
            $responseHeaders = $this->adapter->getHeaders();

            if (NULL !== $responseHeaders['apiCalls']) {
                $this->apiCalls = $responseHeaders['apiCalls'];
            }

            $cacheAge = 0;
            if (NULL !== $responseHeaders['cache']['maxAge']) {
                $cacheAge = $responseHeaders['cache']['maxAge'];
            } elseif (NULL !== $responseHeaders['cache']['expires']) {
                $cacheAge = (new \DateTime())->getTimestamp() - (new \DateTime($responseHeaders['cache']['expires']))->getTimestamp();
            }

            return new Forecast($response, $cacheAge, $responseHeaders['responseTime']);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Returns the number of API calls made "today"
     *
     * @return int
     */
    public function getApiCalls()
    {
        return $this->apiCalls;
    }

    /**
     * Returns the current API key
     *
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }
}
