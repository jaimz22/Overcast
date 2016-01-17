<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:24 PM
 */

namespace VertigoLabs\Overcast\ValueObjects;


class DataBlock
{
    /**
     * @var string
     */
    private $summary;
    /**
     * @var string
     */
    private $icon;
    /**
     * @var DataPoint[]
     */
    private $data;

    public function __construct($data)
    {
        if (isset($data['summary'])) {
            $this->summary = $data['summary'];
        }
        if (isset($data['icon'])) {
            $this->icon = $data['icon'];
        }
        if (isset($data['data'])) {
            foreach ($data['data'] as $dataPoint) {
                $this->data[] = new DataPoint($dataPoint);
            }
        }
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
     * @return DataPoint[]
     */
    public function getData()
    {
        return $this->data;
    }
}
