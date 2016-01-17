<?php
/**
 * @author: James Murray <jaimz@vertigolabs.org>
 * @copyright:
 * @date: 3/31/2015
 * @time: 1:33 PM
 */

namespace VertigoLabs\Overcast\ValueObjects;


class Alert
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var \DateTime
     */
    private $expires;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $uri;

    public function __construct($data)
    {
        if (isset($data['title'])) {
            $this->title = $data['title'];
        }
        if (isset($data['expires'])) {
            $this->expires = (new \DateTime())->setTimestamp($data['expires']);
        }
        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['uri'])) {
            $this->uri = $data['uri'];
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
