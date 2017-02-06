<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 4/14/2015
 * @time: 12:50 PM
 */
namespace VertigoLabs\Overcast\ClientAdapters;

use VertigoLabs\Overcast\ClientAdapterInterface;
use VertigoLabs\Overcast\Overcast;

/**
 * Class FileGetContentsClientAdapter
 *
 * The FileGetContents client adapter uses PHP's built in
 * file_get_contents function to retrieve data from the
 * Dark Sky API
 *
 * @package VertigoLabs\Overcast\ClientAdapters
 */
class FileGetContentsClientAdapter extends ClientAdapter implements ClientAdapterInterface
{
    private $requestedUrl = null;
    private $response = null;
    private $responseHeaders = [];

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
    public function getForecast($latitude, $longitude, \DateTime $time = null, array $parameters = null)
    {
        $this->requestedUrl = $this->buildRequestURL($latitude, $longitude, $time, $parameters);

        $this->response = json_decode(file_get_contents($this->requestedUrl), true);
        $this->responseHeaders = $this->parseForecastResponseHeaders($http_response_header);

        return $this->response;
    }

    /**
     * Returns the relevant response headers from the Dark Sky API
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Parses the response headers
     *
     * @param array $headers
     *
     * @return array
     */
    private function parseForecastResponseHeaders($headers)
    {
        $responseHeaders = [
            'cache' => [
                'maxAge' => null,
                'expires' => null
            ],
            'responseTime' => null,
            'apiCalls' => null
        ];
        foreach ($headers as $header) {
            switch (true) {
                case (substr($header, 0, 14) === 'Cache-Control:'):
                    $responseHeaders['cache']['maxAge'] = trim(substr($header, strrpos($header, '=') + 1));
                    break;
                case (substr($header, 0, 8) === 'Expires:'):
                    $responseHeaders['cache']['expires'] = trim(substr($header, 8));
                    break;
                case (substr($header, 0, 21) === 'X-Forecast-API-Calls:'):
                    $responseHeaders['apiCalls'] = trim(substr($header, 21));
                    break;
                case (substr($header, 0, 16) === 'X-Response-Time:'):
                    $responseHeaders['responseTime'] = (int)trim(substr($header, 16));
                    break;
                default:
                    break;
            }
        }
        return $responseHeaders;
    }
}
