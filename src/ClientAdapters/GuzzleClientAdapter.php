<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 4/14/2015
 * @time: 2:10 PM
 */
namespace VertigoLabs\Overcast\ClientAdapters;

use GuzzleHttp\Client;
use VertigoLabs\Overcast\ClientAdapterInterface;
use VertigoLabs\Overcast\Overcast;

/**
 * Class GuzzleClientAdapter
 *
 * The Guzzle client adapter uses Guzzle to connect to
 * the Dark Sky API
 *
 * @package VertigoLabs\Overcast\ClientAdapters
 */
class GuzzleClientAdapter implements ClientAdapterInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;
    private $requestedUrl = null;
    private $responseHeaders = array();

    /**
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient = null)
    {
        if (is_null($guzzleClient)) {
            $guzzleClient = new Client();
        }
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Returns the response data from the Dark Sky in the
     * form of an array.
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
        $this->requestedUrl = Overcast::API_ENDPOINT . Overcast::getApiKey() . '/' . $latitude . ',' . $longitude;

        if (!is_null($time)) {
            $this->requestedUrl .= ',' . $time->getTimestamp();
        }

        if (!is_null($parameters)) {
            $this->requestedUrl .= '?' . http_build_query($parameters);
        }

        $response = $this->guzzleClient->get($this->requestedUrl);

        $cacheDirectives = $this->buildCacheDirectives($response);

        $this->responseHeaders = array(
            'cache' => $cacheDirectives,
            'responseTime' => (int)current($response->getHeader('x-response-time')),
            'apiCalls' => (int)current($response->getHeader('x-forecast-api-calls'))
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * Returns the relevant response headers from the Dark Sky API.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Builds the cache directives from response headers.
     *
     * @param $response
     *
     * @return string[]
     */
    protected function buildCacheDirectives($response)
    {
        $cacheControlHeader = null;
        if ($response->hasHeader('cache-control')) {
            $cacheControlHeader = $this->parse_header($response->getHeader('cache-control'));
            $cacheControlHeader = current($cacheControlHeader);
            $cacheControlHeader = (isset($cacheControlHeader['max-age'])?$cacheControlHeader['max-age']:null);
        }

        $expiresHeader = null;
        if ($response->hasHeader('expires')){
            $expiresHeader = join(' ',array_column($this->parse_header($response->getHeader('expires')),0));
        }

        return array_filter(array(
            'maxAge'=>$cacheControlHeader,
            'expires'=>$expiresHeader,
        ));
    }

    /**
     * This is taken from the GuzzleHTTP/PSR7 library,
     * see https://github.com/guzzle/psr7 for more info
     *
     * Parse an array of header values containing ";" separated data into an
     * array of associative arrays representing the header key value pair
     * data of the header. When a parameter does not contain a value, but just
     * contains a key, this function will inject a key with a '' string value.
     *
     * @param string|array $header Header to parse into components.
     *
     * @return array Returns the parsed header values.
     */
    protected function parseHeader($header)
    {
        static $trimmed = "\"'  \n\t\r";
        $params = $matches = array();

        foreach ($this->normalizeHeader($header) as $val) {
            $part = array();
            foreach (preg_split('/;(?=([^"]*"[^"]*")*[^"]*$)/', $val) as $kvp) {
                if (preg_match_all('/<[^>]+>|[^=]+/', $kvp, $matches)) {
                    $m = $matches[0];
                    if (isset($m[1])) {
                        $part[trim($m[0], $trimmed)] = trim($m[1], $trimmed);
                    } else {
                        $part[] = trim($m[0], $trimmed);
                    }
                }
            }
            if ($part) {
                $params[] = $part;
            }
        }

        return $params;
    }

    /**
     * This is taken from the GuzzleHTTP/PSR7 library,
     * see https://github.com/guzzle/psr7 for more info
     *
     * Converts an array of header values that may contain comma separated
     * headers into an array of headers with no comma separated values.
     *
     * @param string|array $header Header to normalize.
     *
     * @return array Returns the normalized header field values.
     */
    protected function normalizeHeader($header)
    {
        if (!is_array($header)) {
            return array_map('trim', explode(',', $header));
        }

        $result = array();
        foreach ($header as $value) {
            foreach ((array) $value as $v) {
                if (strpos($v, ',') === false) {
                    $result[] = $v;
                    continue;
                }
                foreach (preg_split('/,(?=([^"]*"[^"]*")*[^"]*$)/', $v) as $vv) {
                    $result[] = trim($vv);
                }
            }
        }

        return $result;
    }
}