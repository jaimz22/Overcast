<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:17 PM
 */

namespace VertigoLabs\Overcast;


class Overcast
{
	const API_ENDPOINT = 'https://api.forecast.io/forecast/';

	private $apiKey = null;
	private $apiCalls = 0;

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * @param $latitude
	 * @param $longitude
	 * @param \DateTime $time
	 *
	 * @return Forecast
	 */
	public function getForecast($latitude, $longitude, \DateTime $time = null)
	{
		$requestUrl = self::API_ENDPOINT.$this->apiKey.'/'.$latitude.','.$longitude;

		if (!is_null($time)) {
			$requestUrl .= ','.$time->getTimestamp();
		}

		$response = json_decode(file_get_contents($requestUrl),true);
		$responseHeaders = $this->parseForecastResponseHeaders($http_response_header);

		if (!is_null($responseHeaders['apiCalls'])) {
			$this->apiCalls = $responseHeaders['apiCalls'];
		}

		$cacheAge = 0;
		if (!is_null($responseHeaders['cache']['maxAge'])) {
			$cacheAge = $responseHeaders['cache']['maxAge'];
		}elseif(!is_null($responseHeaders['cache']['expires'])) {
			$cacheAge = (new \DateTime())->getTimestamp() - (new \DateTime($responseHeaders['cache']['expires']))->getTimestamp();
		}

		return new Forecast($response,$cacheAge, $responseTime);
	}

	/**
	 * @return int
	 */
	public function getApiCalls()
	{
		return $this->apiCalls;
	}

	private function parseForecastResponseHeaders($headers)
	{
		$responseHeaders = [
			'cache' => [
				'maxAge'=>null,
				'expires'=>null
			],
			'responseTime'=>null,
			'apiCalls'=>null
		];
		foreach ($headers as $header) {
			switch (true) {
				case (substr($header,0,14) === 'Cache-Control:'):
					$responseHeaders['cache']['maxAge'] = trim(substr($header,strrpos($header,'=')+1));
					break;
				case (substr($header,0,8) === 'Expires:'):
					$responseHeaders['cache']['expires'] = trim(substr($header,8));
					break;
				case (substr($header,0,21) === 'X-Forecast-API-Calls:'):
					$responseHeaders['apiCalls'] = trim(substr($header,21));
					break;
				case (substr($header,0,16) === 'X-Response-Time:'):
					$responseHeaders['responseTime'] = trim(substr($header,16));
					break;
				default:
					break;
			}
		}
		return $responseHeaders;
	}
}