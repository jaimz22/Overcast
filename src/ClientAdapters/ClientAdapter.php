<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @date: 2/6/2017
 * @time: 7:01 AM
 */

namespace VertigoLabs\Overcast\ClientAdapters;


use VertigoLabs\Overcast\ClientAdapterInterface;
use VertigoLabs\Overcast\Overcast;

abstract class ClientAdapter implements ClientAdapterInterface
{

    /**
     * Builds the URL to request from the Dark Sky API
     *
     * @param float $latitude
     * @param float $longitude
     * @param \DateTime|NULL $time
     * @param array|NULL $parameters
     *
     * @return string
     */
    protected function buildRequestURL($latitude, $longitude, \DateTime $time = NULL, array $parameters = NULL)
    {
        $requestUrl = Overcast::API_ENDPOINT . Overcast::getApiKey() . '/' . $latitude . ',' . $longitude;

        if (NULL !== $time) {
            $requestUrl .= ',' . $time->getTimestamp();
        }

        $requestUrl .= '?' . http_build_query($parameters);

        return $requestUrl;
    }

    /**
     * Returns the response data from the Dark Sky API in the
     * form of an array
     *
     * @param float $latitude
     * @param float $longitude
     * @param \DateTime $time
     * @param array $parameters
     *
     * @return array
     */
    abstract public function getForecast($latitude, $longitude, \DateTime $time = NULL, array $parameters = NULL);

    /**
     * Returns the relevant response headers from the Dark Sky API
     *
     * @return array
     */
    abstract  public function getHeaders();
}
