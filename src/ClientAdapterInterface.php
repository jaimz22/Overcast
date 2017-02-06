<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 4/14/2015
 * @time: 12:48 PM
 */
namespace VertigoLabs\Overcast;

/**
 * Interface ClientAdapterInterface
 *
 * The Client Adapter interface is used to create HTTP clients for
 * connecting the the Dark Sky API
 *
 * @package VertigoLabs\Overcast
 */
interface ClientAdapterInterface
{
    /**
     * Returns the response data from the Dark Sky in the
     * form of an array
     *
     * @param float $latitude
     * @param float $longitude
     * @param \DateTime $time
     * @param array $parameters
     *
     * @return array
     */
    public function getForecast($latitude, $longitude, \DateTime $time = null, array $parameters = null);

    /**
     * Returns the relevant response headers from the Dark Sky API
     *
     * @return array
     */
    public function getHeaders();
}
