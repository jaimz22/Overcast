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
 * the Forecast.io api
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
	private $responseHeaders = [];

	/**
	 * @param Client $guzzleClient
	 */
	public function __construct(Client $guzzleClient = null)
	{
		if (is_null($guzzleClient)){
			$guzzleClient = new Client();
		}
		$this->guzzleClient = $guzzleClient;
	}

	/**
	 * Returns the response data from the Forecast.io in the
	 * form of an array
	 *
	 * @param float $latitude
	 * @param float $longitude
	 * @param \DateTime $time
	 *
	 * @return array
	 */
	public function getForecast($latitude, $longitude, \DateTime $time = null)
	{
		$this->requestedUrl = Overcast::API_ENDPOINT.Overcast::getApiKey().'/'.$latitude.','.$longitude;
		$response = $this->guzzleClient->get($this->requestedUrl);
		$this->responseHeaders = [
			'cache' => [
				'maxAge'=>(int)trim(substr($response->getHeader('cache-control'),strrpos($response->getHeader('cache-control'),'=')+1)),
				'expires'=>$response->getHeader('expires')
			],
			'responseTime'=>(int)$response->getHeader('x-response-time'),
			'apiCalls'=>(int)$response->getHeader('x-forecast-api-calls')
		];
		return $response->json();
	}

	/**
	 * Returns the relevant response headers from the Forecast.io API
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->responseHeaders;
	}
}
