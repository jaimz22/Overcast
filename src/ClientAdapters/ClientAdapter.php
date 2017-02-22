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

        $requestUrl .= '?' . $this->buildRequestParameters($parameters);

        return $requestUrl;
    }

    /**
     * Builds a propery parameter array for use in the query string of a Dark Sky API call
     * @param $parameters
     *
     * @return string|null
     */
    private function buildRequestParameters($parameters)
    {
        if (NULL === $parameters || empty($parameters)) {
            return null;
        }

        if (is_string($parameters)) {
            return $parameters;
        }

        $paramOut = '';
        foreach ($parameters as $key=>$value) {
            $paramOut = $key.'=';
            if (is_array($value)){
                $paramOut .= join(',', $value);
            }else{
                $paramOut .= $value;
            }
        }

        return $paramOut;
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